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

        return response()->json($updated);
    }

    public function destroy($productVariantId)
    {
        $productVariant = ProductVariant::findOrFail($productVariantId);
        $deleted = $productVariant->delete();

        return response()->json($deleted);
    }
}
