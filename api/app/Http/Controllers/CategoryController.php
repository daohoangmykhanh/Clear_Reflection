<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function show($id)
    {
        $category = Category::with('image')->findOrFail($id);

        return response()->json([
            'category' => $category,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string',
            'image_id' => 'integer',
        ]);

        $category = Category::create($validatedData);

        return response()->json([
            'category' => $category,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_name' => 'string',
            'image_id' => 'integer',
        ]);

        $category = Category::findOrFail($id);
        $updated = $category->update($validatedData);

        return response()->json($updated);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $deleted = $category->delete();

        return response()->json($deleted);
    }
}
