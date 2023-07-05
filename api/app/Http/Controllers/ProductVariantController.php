<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index()
    {
        $productVariants = ProductVariant::all();

        return response()->json([
            'product_variants' => $productVariants,
        ]);
    }

    public function show($productId)
    {
        $productVariants = ProductVariant::where('product_id', $productId)->get();

        if ($productVariants->isEmpty()) {
            return response()->json([
                'message' => 'No product variants found for the given product ID.',
            ], 404);
        }

        return response()->json([
            'product_variants' => $productVariants,
        ]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer',
            'height' => 'required|integer',
            'width' => 'required|integer',
            'color_id' => 'required|integer',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'image_id' => 'nullable|integer',
        ]);

        $productVariant = ProductVariant::create($validatedData);

        if (!$productVariant) {
            return response()->json([
                'message' => 'Failed to create product variant.',
            ], 500);
        }

        return response()->json([
            'message' => 'Product variant created successfully.',
            'product_variant' => $productVariant,
        ], 201);
    }

    public function update(Request $request, $productVariantId)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer',
            'height' => 'required|integer',
            'width' => 'required|integer',
            'color_id' => 'required|integer',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'image_id' => 'nullable|integer',
        ]);

        $productVariant = ProductVariant::findOrFail($productVariantId);
        $updated = $productVariant->update($validatedData);

        if (!$updated) {
            return response()->json([
                'message' => 'Failed to update product variant.',
            ], 500);
        }

        return response()->json([
            'message' => 'Product variant updated successfully.',
            'product_variant' => $productVariant,
        ]);
    }

    public function destroy($productVariantId)
    {
        $productVariant = ProductVariant::findOrFail($productVariantId);
        $deleted = $productVariant->delete();

        if (!$deleted) {
            return response()->json([
                'message' => 'Failed to delete product variant.',
            ], 500);
        }

        return response()->json([
            'message' => 'Product variant deleted successfully.',
        ]);
    }
}
