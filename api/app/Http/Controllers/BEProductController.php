<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class BEProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        if ($products->isEmpty()) {
            return response()->json('No results found!');
        }
        $productData = [];
        foreach ($products as $product) {
            $imageData = [];
            foreach ($product->images as $image) {
                $imageData[] = [
                    'image_id' => $image->image_id,
                    'image_url' => $image->image->image_url
                ];
            }
            $category = $product->category;
            $product_shape = $product->product_shape;
            $product_style = $product->product_style;

            $productData[] = [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'description' => $product->description,
                'is_hide' => $product->is_hide,
                'images' => $imageData,
                'category' => [
                    'category_id' => $category->category_id,
                    'category_name' => $category->category_name,
                ],
                'product_shape' => [
                    'product_shape_id' => $product_shape->product_shape_id,
                    'shape_name' => $product_shape->shape_name,
                ],
                'product_style' => [
                    'product_style_id' => $product_style->product_style_id,
                    'style_name' => $product_style->style_name,
                ],
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        }
        return response()->json($productData);
    }

    public function listDetail()
    {
        $products = Product::all();
        if ($products->isEmpty()) {
            return response()->json('No results found!');
        }
        $productData = [];
        foreach ($products as $product) {
            $imageData = [];
            foreach ($product->images as $image) {
                $imageData[] = [
                    'image_id' => $image->image_id,
                    'image_url' => $image->image->image_url
                ];
            }
            $variantData = [];
            $category = $product->category;
            $product_shape = $product->product_shape;
            $product_style = $product->product_style;
            foreach ($product->variants as $variant) {
                $color = $variant->color;
                $image = $variant->image;
                $variantData[] = [
                    'height' => $variant->height,
                    'width' => $variant->width,
                    'color' => [
                        'color_id' => $color->product_color_id,
                        'color_name' => $color->color_name
                    ],
                    'quantity' => $variant->quantity,
                    'price' => $variant->price,
                    'image' => [
                        'image_id' => $image->image_id,
                        'image_url' => $image->image_url
                    ]
                ];
            }
            $productData[] = [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'description' => $product->description,
                'is_hide' => $product->is_hide,
                'images' => $imageData,
                'category' => [
                    'category_id' => $category->category_id,
                    'category_name' => $category->category_name,
                ],
                'product_shape' => [
                    'product_shape_id' => $product_shape->product_shape_id,
                    'shape_name' => $product_shape->shape_name,
                ],
                'product_style' => [
                    'product_style_id' => $product_style->product_style_id,
                    'style_name' => $product_style->style_name,
                ],
                'product_variant' => $variantData,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        }
        return response()->json($productData);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string',
            'description' => 'nullable|string',
            'is_hide' => 'required|boolean',
            'category_id' => 'required|integer',
            'product_shape_id' => 'required|integer',
            'product_style_id' => 'required|integer',
            'product_variant' => 'required|array',
            'image_url' => 'required|array',
            'product_variant.*.height' => 'required|numeric',
            'product_variant.*.width' => 'required|numeric',
            'product_variant.*.color.color_id' => 'nullable|integer',
            'product_variant.*.color.color_name' => 'nullable|string',
            'product_variant.*.quantity' => 'required|integer',
            'product_variant.*.price' => 'required|numeric',
            'product_variant.*.image_url' => 'nullable|string',
        ]);

        $product = new Product();
        $product->product_name = $validatedData['product_name'];
        $product->description = $validatedData['description'];
        $product->is_hide = $validatedData['is_hide'];
        $product->category_id = $validatedData['category_id'];
        $product->product_shape_id = $validatedData['product_shape_id'];
        $product->product_style_id = $validatedData['product_style_id'];
        $product->created_at = now();
        $product->save();

        foreach ($validatedData['image_url'] as $imageUrl) {
            $image = new Image();
            $image->image_url = $imageUrl;
            $image->save();
            $productImage = new ProductImage();
            $productImage->image_id = $image->image_id;
            $productImage->product_id = $product->product_id;
            $productImage->save();
        }

        $variants = [];
        foreach ($validatedData['product_variant'] as $variantData) {
            $variant = new ProductVariant();
            $variant->product_id = $product->product_id;
            $variant->height = $variantData['height'];
            $variant->width = $variantData['width'];
            $variant->quantity = $variantData['quantity'];
            $variant->price = $variantData['price'];

            if (isset($variantData['color'])) {
                if ($variantData['color']['color_id'] != null) {
                    $variant->color_id = $variantData['color']['color_id'];
                } else {
                    $color = new ProductColor();
                    $color->color_name = $variantData['color']['color_name'];
                    $color->save();
                    $variant->color_id = $color->product_color_id;
                }
            }
            if (isset($variantData['image_url'])) {
                $image = new Image();
                $image->image_url = $variantData['image_url'];
                $image->save();
                $variant->image_id = $image->image_id;
            }
            $variants[] = $variant;
        }
        $product->variants()->saveMany($variants);

        return response()->json([
            'message' => 'Product created successfully.',
            'product' => $product,
            'variant' => $variants,
            'image_url' => $validatedData['image_url']
        ], 201);
    }
}
