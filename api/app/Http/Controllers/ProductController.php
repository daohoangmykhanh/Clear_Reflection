<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'product_shape', 'product_style', 'images', 'variants')->get();

        return response()->json([
            'products' => $products,
        ]);
    }

    public function show($id)
    {
        $product = Product::with('category', 'productShape', 'productStyle', 'images', 'variants')->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found.',
            ], 404);
        }

        return response()->json([
            'product' => $product,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string',
            'description' => 'nullable|string',
            'is_hide' => 'boolean',
            'category_id' => 'integer',
            'product_shape_id' => 'integer',
            'product_style_id' => 'integer',
        ]);

        $product = Product::create($validatedData);

        return response()->json([
            'message' => 'Product created successfully.',
            'product' => $product,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_name' => 'string',
            'description' => 'nullable|string',
            'is_hide' => 'boolean',
            'category_id' => 'integer',
            'product_shape_id' => 'integer',
            'product_style_id' => 'integer',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found.',
            ], 404);
        }

        $product->update($validatedData);

        return response()->json([
            'message' => 'Product updated successfully.',
            'product' => $product,
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found.',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }
}
