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
                'colorName' => $productVariant->product_color->color_name ?? null,
                'quantity' => $productVariant->quantity ?? null,
                'price' => $productVariant->price ?? null,
                'imageId' => $productVariant->image_id ?? null,
            ];
        }

        return response()->json([
            'product_variants' => $productVariantData,
        ]);
    }


    public function show($productId)
    {
        $productVariants = ProductVariant::where('product_id', $productId)->get();

        if ($productVariants->isEmpty()) {
            return response()->json([
                'result' => false,
                'message' => 'No product variants found for the given product ID.',
            ], 404);
        }

        return response()->json([
            'product_variants' =>  [
                'productId' => $productVariants->product_id,
                'height' => $productVariants->height,
                'width' => $productVariants->width,
                'colorName' => $productVariants->product_color->color_name ?? null,
                'quantity' => $productVariants->quantity ?? null,
                'price' => $productVariants->price ?? null,
                'imageId' => $productVariants->image_id ?? null,
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
                'colorName' => $productVariant->product_color->color_name ?? null,
                'quantity' => $productVariant->quantity ?? null,
                'price' => $productVariant->price ?? null,
                'imageId' => $productVariant->image_id ?? null,
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
