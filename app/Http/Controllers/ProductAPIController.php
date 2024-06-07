<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use App\Models\Tariff;
use Throwable;

use Illuminate\Http\Request;

class ProductAPIController extends Controller
{
    public function index()
    {
        $products = Product::with(['tariffs', 'images', 'categories'])->get();
        return response()->json([
            $products
        ]);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $selectedCategories = Category::whereHas('products', function ($query) use ($id) {
            $query->where('product_id', $id);
        })->get();
        return response()->json([
            "product" => $product,
            "categories" => $selectedCategories
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);

            if ($request->code !== $product->code) {
                $request->validate([
                    'code' => 'required|string|unique:products',
                ]);
            }

            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'tariffs' => 'required|array|min:1',
                function ($value, $fail) {
                    foreach ($value as $tariffData) {
                        $startDate = $tariffData['start_date'];
                        $endDate = $tariffData['end_date'];

                        if ($endDate < $startDate) {
                            $fail('La fecha de finalización debe ser posterior a la fecha de inicio.');
                        }
                    }
                },
                'tariffs.*.start_date' => 'required|date',
                'tariffs.*.end_date' => 'required|date|after:tariffs.*.start_date',
                'tariffs.*.price' => 'required|numeric',
                'categories' => 'nullable',
                'categories.*' => 'exists:categories,id',
                'photos' => 'required|array|min:1',
                'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $product->code = $request->code;
            $product->name = $request->name;
            $product->description = $request->description;

            if ($request->categories !== null) {
                $categories = $request->categories;
                $product->categories()->sync($categories);

                foreach ($categories as $category_id) {
                    $category = Category::find($category_id);
                    $parent_category = $category->parent;

                    if ($parent_category) {
                        if (!$product->categories->contains($parent_category->id)) {
                            $product->categories()->attach($parent_category->id);
                        }
                    }
                }
            }

            $product->tariffs()->delete();

            foreach ($request->tariffs as $tariffData) {
                $tariff = new Tariff();
                $tariff->product_id = $product->id;
                $tariff->start_date = $tariffData['start_date'];
                $tariff->end_date = $tariffData['end_date'];
                $tariff->price = $tariffData['price'];
                $tariff->save();
            }

            $product->images()->delete();

            if ($request->hasFile('photos')) {

                foreach ($request->file('photos') as $image) {
                    $path = $image->store('images', 'public');

                    $imageModel = new Image();
                    $imageModel->product_id = $product->id;
                    $imageModel->image_path = $path;
                    $imageModel->save();
                }
            }
        } catch (Throwable) {
            return response()->json([
                "ERROR: The product has not been updated."
            ]);
        }

        return response()->json([
            "The product has been updated."
        ]);
    }
}
