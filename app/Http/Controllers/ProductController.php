<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductPostRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use App\Models\Tariff;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * Función para mostrar los productos
     */
    public function index()
    {
        $products = Product::with(['categories', 'images', 'tariffs'])->get();
        return view('products.index', compact('products'));
    }

    /**
     * Función para descargar un PDF con la información de un producto en concreto
     */
    public function show($id)
    {
        $product = Product::find($id);

        $data = [
            'product' => $product
        ];

        $pdf = PDF::loadView('products.view', $data);

        return $pdf->download($product->name . '.pdf');
    }


    /**
     * Función para editar un producto, se muestra el formulario de edición
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $selectedCategories = Category::whereHas('products', function ($query) use ($id) {
            $query->where('product_id', $id);
        })->get();
        return view('products.edit', compact(['product', 'categories', 'selectedCategories']));
    }

    /**
     * Función para actualizar un producto
     */
    public function update(ProductPostRequest $request, $id) : RedirectResponse
    {
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

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Función para crear un producto, se muestra el formulario de creación
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }


    /**
     * Función para guardar un nuevo producto
     */
    public function store(ProductPostRequest $request)
    {
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

        // Sincronizamos las categorías
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

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }


    /**
     * Función para eliminar un producto
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->images()->delete();
        $product->tariffs()->delete();
        $product->categories()->detach();
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
