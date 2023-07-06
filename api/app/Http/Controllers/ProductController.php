<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'product_shape', 'product_style', 'images', 'variants')->get();
        $productData = [];

        foreach ($products as $product) {
            $productData[] = [
                'productId' => $product->product_id,
                'productName' => $product->product_name,
                'description' => $product->description,
                'isHide' => $product->is_hide,
                'categoryId' => $product->category_id,
                'productShapeId' => $product->product_shape_id,
                'productStyleId' => $product->product_style_id,
            ];
        }

        return response()->json([
            'products' => $productData,
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
            'product' =>  [
                'productId' => $product->product_id,
                'productName' => $product->product_name,
                'description' => $product->description,
                'isHide' => $product->is_hide,
                'categoryId' => $product->category_id,
                'productShapeId' => $product->product_shape_id,
                'productStyleId' => $product->product_style_id,
            ]
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
            'product' => [
                'productId' => $product->product_id,
                'productName' => $product->product_name,
                'description' => $product->description,
                'isHide' => $product->is_hide,
                'categoryId' => $product->category_id,
                'productShapeId' => $product->product_shape_id,
                'productStyleId' => $product->product_style_id,
            ]
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
                'result' => false,
                'message' => 'Product not found.',
            ]);
        }

        $updated = $product->update($validatedData);

        if ($updated) {
            return response()->json([
                'result' => true,
                'message' => 'Product updated successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to update product.',
            ]);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'result' => false,
                'message' => 'Product not found.',
            ]);
        }

        $deleted = $product->delete();

        if ($deleted) {
            return response()->json([
                'result' => true,
                'message' => 'Product deleted successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete product.',
            ]);
        }
    }
}
