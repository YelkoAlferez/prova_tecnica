<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductPostRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use App\Models\Tariff;
use Illuminate\Http\JsonResponse;
use Throwable;

use Illuminate\Http\Request;

class ProductAPIController extends Controller
{
    /**
     * Función para mostrar los productos, en caso de no haber, muestra que no hay
     */
    public function index()
    {
        $products = Product::with(['tariffs', 'images', 'categories'])->get();
        if ($products === null) {
            return response()->json([
                "No products found"
            ]);
        }
        return response()->json([
            $products
        ]);
    }

    /**
     * Función para editar un producto, muestra el producto, en caso de no encontrarlo, muestra que no existe
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $selectedCategories = Category::whereHas('products', function ($query) use ($id) {
            $query->where('product_id', $id);
        })->get();

        if ($product === null) {
            return response()->json([
                "Product not found"
            ]);
        }

        return response()->json([
            "product" => $product,
            "categories" => $selectedCategories
        ]);
    }

    /**
     * Función para actualizar un producto, en caso de no poder actualizarse, se muestra un mensaje de error
     */
    public function update(ProductPostRequest $request, $id) : JsonResponse
    {
        try {
            $product = Product::find($id);

            // Comprobamos los campos del formulario
            if ($request->code !== $product->code) {
                $validated = $request->safe()->only('code');
            }

            $validated = $request->safe()->except('code');

            // Actualizamos el producto
            $product->code = $request->code;
            $product->name = $request->name;
            $product->description = $request->description;

            // Actualizamos las categorias, con su respectiva categoria padre, en caso de tenerla
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

            // Borramos las tarifas asociadas a ese producto y añadimos las nuevas
            $product->tariffs()->delete();

            foreach ($request->tariffs as $tariffData) {
                $tariff = new Tariff();
                $tariff->product_id = $product->id;
                $tariff->start_date = $tariffData['start_date'];
                $tariff->end_date = $tariffData['end_date'];
                $tariff->price = $tariffData['price'];
                $tariff->save();
            }

            // Borramos las imagenes asociadas a ese producto y añadimos las nuevas
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

        // Mostramos que se ha podido actualizar el producto
        return response()->json([
            "The product has been updated."
        ]);
    }

    /**
     * Función para guardar un nuevo producto, en caso de no poder crearse, se muestra un mensaje de error
     */
    public function store(ProductPostRequest $request) : JsonResponse
    {
        try {
            
            // Comprobamos los campos del formulario
            $validated = $request->validated();

            // Creamos el producto
            $product = new Product();
            $product->code = $request->code;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->save();

            // Guardamos las tarifas
            foreach ($request->tariffs as $tariffData) {
                $tariff = new Tariff();
                $tariff->product_id = $product->id;
                $tariff->start_date = $tariffData['start_date'];
                $tariff->end_date = $tariffData['end_date'];
                $tariff->price = $tariffData['price'];
                $tariff->save();
            }

            // Sincronizamos categorías
            $categories = $request->categories;
            $product->categories()->sync($categories);

            // Agregamos también las categorías padre
            foreach ($categories as $category_id) {
                $category = Category::find($category_id);
                $parent_category = $category->parent;

                if ($parent_category) {
                    if (!$product->categories->contains($parent_category->id)) {
                        $product->categories()->attach($parent_category->id);
                    }
                }
            }

            // Guardamos las fotos del producto
            foreach ($request->file('photos') as $image) {
                $path = $image->store('images', 'public');

                $imageModel = new Image();
                $imageModel->product_id = $product->id;
                $imageModel->image_path = $path;
                $imageModel->save();
            }

        } catch (Throwable) {
            return response()->json([
                "Product not created"
            ]);
        }

        // Devolvemos que se ha podido crear el producto
        return response()->json([
            "Product created"
        ]);
    }

    /**
     * Función para eliminar un producto, en caso de no existir, se muestra un mensaje de error
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product === null) {
            return response()->json([
                "ERROR: Product not found"
            ]);
        }
        $product->images()->delete();
        $product->tariffs()->delete();
        $product->categories()->detach();
        $product->delete();

        return response()->json([
            "The product has been deleted"
        ]);
    }
}
