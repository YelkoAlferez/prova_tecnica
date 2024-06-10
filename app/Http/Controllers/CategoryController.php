<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    /**
     * Función para mostrar las categorias, pasandole como datos la categoria, con su resepctiva categoría padre
     */
    public function index()
    {
        $categories = Category::with('parent')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Función para destruir una categoria
     */
    public function destroy($id)
    {
        $categories = Category::all();
        $categoria = Category::find($id);

        // Si la categoria tiene productos asignados, no se puede eliminar
        if ($categoria->products()->count() > 0) {
            return redirect()->route('categories.index')->withErrors([
                'La categoria té productes assignats',
            ]);
        }

        // Si la categoria es categoria padre no se puede eliminar
        foreach ($categories as $category) {

            if ($category->parent_id === $categoria->id) {
                return redirect()->route('categories.index')->withErrors([
                    'La categoria és una categoria pare',
                ]);
            }
        }

        // Si no tiene productos ni es categoria padre, se elimina
        $categoria->delete();

        return redirect()->route('categories.index');
    }

    /**
     * Función para editar una categoria, pasandole como datos la categoria, con su resepctiva categoría padre y las demás categorias, muestra el formulario de edición
     */
    public function edit($categoria)
    {
        $categoria = Category::with('parent')->find($categoria);
        $categories = Category::all();
        return view('categories.edit', compact('categories'), ['categoria' => $categoria]);
    }

    /**
     * Función para actualizar la categoria
     */
    public function update(Request $request, $id)
    {

        //Comprobamos los campos del formulario
        $category = Category::find($id);
        if ($category->code !== $request->code) {
            $request->validate([
                'code' => 'required|unique:categories,code',
            ]);
        }
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'parent_id' => 'nullable'
        ]);

        // Si el parent_id es 0 (no tiene categoria padre), se le asigna un null, sinó se le asigna ese parent_id
        if ($request->parent_id == 0) {
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
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Función para crear una categoria, muestra el formulario de creación
     */
    public function create()
    {
        $categories = Category::all();
        return view('categories.create', compact('categories'));
    }

    /**
     * Función para guardar una nueva categoria
     */
    public function store(Request $request)
    {

        // Comprueba los campos del formulario
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

        // Creamos la categoria
        Category::insert([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $parent_id,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }
}
