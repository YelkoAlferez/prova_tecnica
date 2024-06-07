<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function index()
    {
            $categories = Category::with('parent')->get();
            return view('categories.index', compact('categories'));
    }

    public function destroy($id)
    {
        $categories = Category::all();
        $categoria = Category::find($id);

        if ($categoria->products()->count() > 0) {
            return redirect()->route('categories.index')->withErrors([
                'La categoria té productes assignats',
            ]);
        }

        foreach ($categories as $category) {

            if ($category->parent_id === $categoria->id) {
                return redirect()->route('categories.index')->withErrors([
                    'La categoria és una categoria pare',
                ]);
            }
        }

        $categoria->delete();

        return redirect()->route('categories.index');
    }

    public function edit($categoria)
    {
        $categoria = Category::with('parent')->find($categoria);
        $categories = Category::all();
        return view('categories.edit', compact('categories'), ['categoria' => $categoria]);
    }

    public function update(Request $request, $id)
    {

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


        if ($request->parent_id == 0) {
            $parent_id = null;
        } else {
            $parent_id = $request->parent_id;
        }

        $category->code = $request->code;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->parent_id = $parent_id;
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    public function create()
    {
        $categories = Category::all();
        return view('categories.create', compact('categories'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'code' => 'required|unique:categories',
            'name' => 'required',
            'description' => 'required',
            'parent_id' => 'nullable'
        ]);

        if ($request->parent_id == 0) {
            $parent_id = null;
        } else {
            $parent_id = $request->parent_id;
        }


        Category::insert([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $parent_id,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }
}
