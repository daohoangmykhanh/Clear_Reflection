<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index()
    {
        $productVariants = ProductVariant::all();
        $productVariantData = [];

        foreach ($productVariants as $productVariant) {
            $productVariantData[] = [
                'productId' => $productVariant->product_id,
                'height' => $productVariant->height,
                'width' => $productVariant->width,
                'colorId' => $productVariant->color_id,
                'quantity' => $productVariant->quantity,
                'price' => $productVariant->price,
                'imageId' => $productVariant->image_id,
            ];
        }

        return response()->json([
            'product_variants' => $productVariantData,
        ]);
    }


    public function show($productId)
    {
        $productVariant = ProductVariant::where('product_id', $productId)->get();

        if ($productVariant->isEmpty()) {
            return response()->json([
                'message' => 'No product variants found for the given product ID.',
            ], 404);
        }

        return response()->json([
            'product_variants' =>  [
                'productId' => $productVariant->product_id,
                'height' => $productVariant->height,
                'width' => $productVariant->width,
                'colorId' => $productVariant->color_id,
                'quantity' => $productVariant->quantity,
                'price' => $productVariant->price,
                'imageId' => $productVariant->image_id,
            ]
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
            'product_variant' =>  [
                'productId' => $productVariant->product_id,
                'height' => $productVariant->height,
                'width' => $productVariant->width,
                'colorId' => $productVariant->color_id,
                'quantity' => $productVariant->quantity,
                'price' => $productVariant->price,
                'imageId' => $productVariant->image_id,
            ]
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

    if ($updated) {
        return response()->json([
            'result' => true,
            'message' => 'Product variant updated successfully.',
        ]);
    } else {
        return response()->json([
            'result' => false,
            'message' => 'Failed to update product variant.',
        ]);
    }
}

public function destroy($productVariantId)
{
    $productVariant = ProductVariant::findOrFail($productVariantId);
    $deleted = $productVariant->delete();

    if ($deleted) {
        return response()->json([
            'result' => true,
            'message' => 'Product variant deleted successfully.',
        ]);
    } else {
        return response()->json([
            'result' => false,
            'message' => 'Failed to delete product variant.',
        ]);
    }
}
}
