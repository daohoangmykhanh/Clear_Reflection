<?php

namespace App\Http\Controllers;

use App\Models\ProductColor;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{
    public function index()
    {
        $productColors = ProductColor::all();
        $productColorData = [];

        foreach ($productColors as $productColor) {
            $productColorData[] = [
                'productColorId' => $productColor->product_color_id,
                'colorName' => $productColor->color_name,
            ];
        }

        return response()->json([
            'product_colors' => $productColorData,
        ]);
    }

    public function show($productColorId)
    {
        $productColor = ProductColor::findOrFail($productColorId);

        return response()->json([
            'product_color' => [
                'productColorId' => $productColor->product_color_id,
                'colorName' => $productColor->color_name,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'color_name' => 'required|string',
        ]);

        $productColor = ProductColor::create($validatedData);

        return response()->json([
            'message' => 'Product color created successfully',
            'product_color' => $productColor
        ], 201);
    }

    public function update(Request $request, $productColorId)
    {
        $validatedData = $request->validate([
            'color_name' => 'required|string',
        ]);

        $productColor = ProductColor::findOrFail($productColorId);
        $productColor->update($validatedData);

        return response()->json([
            'message' => 'Product color updated successfully',
            'product_color' => $productColor
        ]);
    }

    public function destroy($productColorId)
    {
        $productColor = ProductColor::findOrFail($productColorId);
        $productColor->delete();

        return response()->json(['message' => 'Product color deleted successfully']);
    }
}
