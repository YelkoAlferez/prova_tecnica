<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use App\Models\Tariff;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::find($id);

        $data = [
            'product' => $product
        ];

        $pdf = PDF::loadView('products.view', $data);

        return $pdf->download($product->name . '.pdf');
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function index()
    {
        $products = Product::with(['categories', 'images', 'tariffs'])->get();
        return view('products.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $selectedCategories = Category::whereHas('products', function ($query) use ($id) {
            $query->where('product_id', $id);
        })->get();
        return view('products.edit', compact(['product', 'categories', 'selectedCategories']));
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        // Validación para el campo 'code' si es diferente
        if ($request->code !== $product->code) {
            $request->validate([
                'code' => 'required|string|unique:products',
            ]);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tariffs' => 'required|array|min:1',
            function ($attribute, $value, $fail) {
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
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

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }


    public function store(Request $request)
    {
        // Validación para los demás campos
        $request->validate([
            'code' => 'required|string|unique:products',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tariffs' => 'required|array|min:1',
            'tariffs.*.start_date' => 'required|date',
            'tariffs.*.end_date' => 'required|date|after:tariffs.*.start_date',
            'tariffs.*.price' => 'required|numeric',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $product = new Product();
        $product->code = $request->code;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();

        // Guardar tarifas
        foreach ($request->tariffs as $tariffData) {
            $tariff = new Tariff();
            $tariff->product_id = $product->id;
            $tariff->start_date = $tariffData['start_date'];
            $tariff->end_date = $tariffData['end_date'];
            $tariff->price = $tariffData['price'];
            $tariff->save();
        }

        // Sincronizar categorías
        $categories = $request->categories;
        $product->categories()->sync($categories);

        // Agregar también las categorías padre
        foreach ($categories as $category_id) {
            $category = Category::find($category_id);
            $parent_category = $category->parent;

            if ($parent_category) {
                if (!$product->categories->contains($parent_category->id)) {
                    $product->categories()->attach($parent_category->id);
                }
            }
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $image) {
                $path = $image->store('images', 'public');

                $imageModel = new Image();
                $imageModel->product_id = $product->id;
                $imageModel->image_path = $path;
                $imageModel->save();
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }



    public function destroy($id)
    {
        $product = Product::find($id);
        $product->images()->delete();
        $product->categories()->detach();
        $product->delete();

        return redirect()->route('products.index');
    }
}
