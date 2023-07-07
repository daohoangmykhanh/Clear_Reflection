<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function index()
    {
        $productImages = ProductImage::all();
        $productImageData = [];

        foreach ($productImages as $productImage) {
            $productImageData[] = [
                'productId' => $productImage->product_id,
                'imageId' => $productImage->image_id,
            ];
        }

        return response()->json([
            'productImages' => $productImageData,
        ]);
    }

    public function show($productId, $imageId)
    {
        $productImage = ProductImage::where('product_id', $productId)
            ->where('image_id', $imageId)
            ->firstOrFail();

        return response()->json([
            'product_image' => [
                'productId' => $productImage->product_id,
                'imageId' => $productImage->image_id,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer',
            'image_id' => 'required|integer',
        ]);

        $productImage = ProductImage::create($validatedData);

        return response()->json([
            'product_image' => [
                'productId' => $productImage->product_id,
                'imageId' => $productImage->image_id,
            ],
        ], 201);
    }

    public function destroy($productId, $imageId)
    {
        $productImage = ProductImage::where('product_id', $productId)
            ->where('image_id', $imageId)
            ->firstOrFail();

        $deleted = $productImage->delete();

        if ($deleted) {
            return response()->json([
                'result' => true,
                'message' => 'Product image deleted successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete product image.',
            ]);
        }
    }
}
