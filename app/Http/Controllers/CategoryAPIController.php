<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Throwable;

class CategoryAPIController extends Controller
{
    /**
     * Función para retornar las categorias, en caso de no haber, muestra que no hay categorias
     */
    public function index()
    {
        $categories = Category::with('parent')->get();
        if($categories === null){
            return response()->json([
                "No categories found"
            ]);
        }
        return response()->json([
            $categories
        ]);
    }

    /**
     * Función para retornar una categoria, junto con su categoria padre, en caso de tener una
     */
    public function edit($categoria)
    {
        $categoria = Category::with('parent')->find($categoria);
        return response()->json([
            $categoria
        ]);
    }

    /**
     * Función para actualizar una categoria, en caso de no poder actualizarse, muestra un error
     */
    public function update(Request $request, $id)
    {
        try {
            // Buscamos la categoria y validamos los campos del formulario
            $category = Category::find($id);
            if ($category->code !== $request->code) {
                $request->validate([
                    'code' => 'required|unique:categories,code',
                ]);
            }
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'parent_id' => 'nullable|exists:categories,id'
            ]);


            // Si el parent_id es 0 (no tiene categoria padre), se le asigna un null, sinó se le asigna ese parent_id
            if ($request->parent_id === 0) {
                $parent_id = null;
            } else {
                $parent_id = $request->parent_id;
            }

            // Actualizamos la categoria y la guardamos
            $category->code = $request->code;
            $category->name = $request->name;
            $category->description = $request->description;
            $category->parent_id = $parent_id;
            $category->save();
        } catch (Throwable) {
            return response()->json([
                "ERROR: The category has not been updated."
            ]);
        }

        // Devolvemos que la categoria se ha podido actualizar
        return response()->json([
            "The category has been updated."
        ]);
    }

    /**
     * Función para crear una categoria, en caso de no poder crearse, muestra un error
     */
    public function store(Request $request)
    {
        try {
            // Validamos los campos del formulario
            $request->validate([
                'code' => 'required|unique:categories',
                'name' => 'required',
                'description' => 'required',
                'parent_id' => 'nullable'
            ]);

            $parent = Category::find($request->parent_id);
            // Si el parent_id es 0 (no tiene categoria padre), se le asigna un null, sinó se le asigna ese parent_id
            if ($request->parent_id === 0 || $parent->parent_id !== null) {
                $parent_id = null;
            } else {
                $parent_id = $request->parent_id;
            }

            // Creamos una nueva categoria con esos datos
            Category::insert([
                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,
                'parent_id' => $parent_id,
            ]);

        }catch(Throwable){
            return response()->json([
                "ERROR: Category not created"
            ]);
        }

        // Devolvemos que se ha podido crear la categoria
        return response()->json([
            "Category created"
        ]);
    }

    /**
     * Función para destruir una categoria, en caso de no existir, muestra un error
     */
    public function destroy($id)
    {
        $categories = Category::all();
        $categoria = Category::find($id);

        if ($categoria->products()->count() > 0) {
            return response()->json([
                "ERROR: This category has products"
            ]);
        }

        foreach ($categories as $category) {

            if ($category->parent_id === $categoria->id) {
                return response()->json([
                    "ERROR: This category is a parent category"
                ]);
            }
        }

        if($categoria === null){
            return response()->json([
                "ERROR: Category not found"
            ]);
        }

        $categoria->delete();

        return response()->json([
            "The category has beeen deleted"
        ]);
    }
}
