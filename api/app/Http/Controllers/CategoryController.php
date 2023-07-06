<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $categoryData = [];

        foreach ($categories as $category) {
            $categoryData[] = [
                'categoryId' => $category->category_id,
                'category_name' => $category->category_name,
                'image_id' => $category->image_id,
            ];
        }

        return response()->json([
            'categories' => $categoryData,
        ]);
    }


    public function show($id)
    {
        $category = Category::with('image')->findOrFail($id);

        return response()->json([
            'category' => [
                'categoryId' => $category->category_id,
                'category_name' => $category->category_name,
                'image_id' => $category->image_id,
            ]
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
            'category' => [
                'categoryId' => $category->category_id,
                'category_name' => $category->category_name,
                'image_id' => $category->image_id,
            ]
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

        if ($updated) {
            return response()->json([
                'result' => true,
                'message' => 'Category updated successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to update category.',
            ]);
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $deleted = $category->delete();

        if ($deleted) {
            return response()->json([
                'result' => true,
                'message' => 'Category deleted successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete category.',
            ]);
        }
    }
}
