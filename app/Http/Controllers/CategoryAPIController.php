<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Throwable;

class CategoryAPIController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->get();
        return response()->json([
            $categories
        ]);
    }

    public function edit($categoria)
    {
        $categoria = Category::with('parent')->find($categoria);
        return response()->json([
            $categoria
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
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
        } catch (Throwable) {
            return response()->json([
                "ERROR: The category has not been updated."
            ]);
        }

        return response()->json([
            "The category has been updated."
        ]);
    }
}
