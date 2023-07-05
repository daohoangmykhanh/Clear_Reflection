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
    public function index(){
        $products = Product::all();
        if($products -> isEmpty()){
            return response()->json('No results found!');
        }
        $productData = [];
        foreach($products as $product){
            $imageData = [];
            foreach($product -> images as $image){
                $imageData[] = [
                    'imageId' => $image -> image_id,
                    'imageUrl' => $image -> image -> image_url
                ];
            }
            $category = $product->category;
            $product_shape = $product->product_shape;
            $product_style = $product->product_style;

            $productData[] = [
                'productId' => $product->product_id,
                'productName' => $product -> product_name,
                'description' => $product->description,
                'isHide' => $product->is_hide,
                'imageUrls' => $imageData,
                'category' => [
                    'categoryId' => $category->category_id,
                    'categoryName' => $category->category_name,
                ],
                'productShape' => [
                    'productShapeId' => $product_shape->product_shape_id,
                    'shapeName' => $product_shape->shape_name,
                ],
                'productStyle' => [
                    'productStyleId' => $product_style->product_style_id,
                    'styleName' => $product_style->style_name,
                ],
                'createdAt' => $product->created_at,
                'updatedAt' => $product->updated_at,
            ];
        }
        return response()->json($productData);
    }

    public function listDetail(){
        $products = Product::all();
        if($products -> isEmpty()){
            return response()->json('No results found!');
        }
        $productData = [];
        foreach($products as $product){
            $imageData = [];
            foreach($product -> images as $image){
                $imageData[] = [
                    'imageId' => $image -> image_id,
                    'imageUrl' => $image -> image -> image_url
                ];
            }
            $variantData = [];
            $category = $product->category;
            $product_shape = $product->product_shape;
            $product_style = $product->product_style;
            foreach($product->variants as $variant){
                $color = $variant -> color;
                $image = $variant -> image;
                $variantData[] = [
                    'height' => $variant ->height,
                    'width' => $variant -> width,
                    'color' => [
                        'colorId' => $color -> product_color_id,
                        'colorName' => $color -> color_name
                    ],
                    'quantity' => $variant->quantity,
                    'price' => $variant->price,
                    'image' => [
                        'imageId' => $image -> image_id,
                        'imageUrl' => $image -> image_url
                    ]
                ];
            }
            $productData[] = [
                'productId' => $product->product_id,
                'productName' => $product -> product_name,
                'description' => $product->description,
                'isHide' => $product->is_hide,
                'images' => $imageData,
                'category' => [
                    'categoryId' => $category->category_id,
                    'categoryName' => $category->category_name,
                ],
                'productShape' => [
                    'productShapeId' => $product_shape->product_shape_id,
                    'shapeName' => $product_shape->shape_name,
                ],
                'productStyle' => [
                    'productStyleId' => $product_style->product_style_id,
                    'styleName' => $product_style->style_name,
                ],
                'productVariant' => $variantData,
                'createdAt' => $product->created_at,
                'updatedAt' => $product->updated_at,
            ];
        }
        return response()->json($productData);
    }

    public function create (Request $request){
        $validatedData = $request->validate([
            'productName' => 'required|string',
            'description' => 'nullable|string',
            'isHide' => 'required|boolean',
            'categoryId' => 'required|integer',
            'productShapeId' => 'required|integer',
            'productStyleId' => 'required|integer',
            'productVariant' => 'required|array',
            'imageUrl' => 'required|array',
            'productVariant.*.height' => 'required|numeric',
            'productVariant.*.width' => 'required|numeric',
            'productVariant.*.color.colorId' => 'nullable|integer',
            'productVariant.*.color.colorName' => 'nullable|string',
            'productVariant.*.quantity' => 'required|integer',
            'productVariant.*.price' => 'required|numeric',
            'productVariant.*.imageUrl' => 'nullable|string',
        ]);

        $product = new Product();
        $product-> product_name = $validatedData['productName'];
        $product -> description = $validatedData['description'];
        $product -> is_hide = $validatedData['isHide'];
        $product -> category_id = $validatedData['categoryId'];
        $product -> product_shape_id = $validatedData['productShapeId'];
        $product -> product_style_id = $validatedData['productStyleId'];
        $product -> created_at = now();
        $product -> save();

        foreach($validatedData['imageUrl'] as $imageUrl){
            $image = new Image();
            $image -> image_url = $imageUrl;
            $image -> save();
            $productImage = new ProductImage();
            $productImage -> image_id = $image -> image_id;
            $productImage -> product_id = $product -> product_id;
            $productImage -> save();
        }

        $variants = [];
        foreach($validatedData['productVariant'] as $variantData){
            $variant = new ProductVariant();
            $variant -> product_id = $product->product_id;
            $variant -> height = $variantData['height'];
            $variant -> width = $variantData['width'];
            $variant -> quantity = $variantData['quantity'];
            $variant -> price = $variantData['price'];

            if(isset($variantData['color'])){
                if($variantData['color']['colorId'] != null){
                    $variant -> color_id = $variantData['color']['colorId'];
                } else {
                    $color = new ProductColor();
                    $color -> color_name = $variantData['color']['colorName'];
                    $color -> save();
                    $variant -> color_id = $color -> product_color_id;
                }
            }
            if(isset($variantData['imageUrl'])){
                $image = new Image();
                $image -> image_url = $variantData['imageUrl'];
                $image -> save();
                $variant -> image_id = $image -> image_id;
            }
            $variants[] = $variant;
        }
        $product->variants()->saveMany($variants);

        return response()->json([
            'message' => 'Product created successfully.',
            'product' => $product,
            'variant' => $variants,
            'imageUrl' => $validatedData['imageUrl']
        ], 201);
    }

    public function edit ($id){
        $product = Product::Find($id);
        if(!$product){
            return response()->json('No results found!');
        }
        $productData = [];
        $imageData = [];
        foreach($product -> images as $image){
            $imageData[] = [
                'imageId' => $image -> image_id,
                'imageUrl' => $image -> image -> image_url
            ];
        }
        $variantData = [];
        $category = $product->category;
        $product_shape = $product->product_shape;
        $product_style = $product->product_style;
        foreach($product->variants as $variant){
            $color = $variant -> color;
            $image = $variant -> image;
            $variantData[] = [
                'productVariantId' => $variant -> product_variant_id,
                'height' => $variant ->height,
                'width' => $variant -> width,
                'color' => [
                    'colorId' => $color -> product_color_id,
                    'colorName' => $color -> color_name
                ],
                'quantity' => $variant->quantity,
                'price' => $variant->price,
                'image' => [
                    'imageId' => $image -> image_id,
                    'imageUrl' => $image -> image_url
                ]
            ];
        }
        $productData[] = [
            'productId' => $product->product_id,
            'productName' => $product -> product_name,
            'description' => $product->description,
            'isHide' => $product->is_hide,
            'images' => $imageData,
            'category' => [
                'categoryId' => $category->category_id,
                'categoryName' => $category->category_name,
            ],
            'productShape' => [
                'productShapeId' => $product_shape->product_shape_id,
                'shapeName' => $product_shape->shape_name,
            ],
            'productStyle' => [
                'productStyleId' => $product_style->product_style_id,
                'styleName' => $product_style->style_name,
            ],
            'productVariant' => $variantData,
            'createdAt' => $product->created_at,
            'updatedAt' => $product->updated_at,
        ];
        
        return response()->json($productData);
    }

    public function update(Request $request, $id){
        $product = Product::Find($id);
        $validatedData = $request->validate([
            'productName' => 'required|string',
            'description' => 'nullable|string',
            'isHide' => 'required|boolean',
            'categoryId' => 'required|integer',
            'productShapeId' => 'required|integer',
            'productStyleId' => 'required|integer',
            'productVariant' => 'required|array',
            'imageUrl' => 'required|array',
            'productVariant.*.height' => 'required|numeric',
            'productVariant.*.productVariantId' => 'nullable|integer',
            'productVariant.*.width' => 'required|numeric',
            'productVariant.*.color.colorId' => 'nullable|integer',
            'productVariant.*.color.colorName' => 'nullable|string',
            'productVariant.*.quantity' => 'required|integer',
            'productVariant.*.price' => 'required|numeric',
            'productVariant.*.imageUrl' => 'nullable|string',
        ]);
        $product-> product_name = $validatedData['productName'];
        $product -> description = $validatedData['description'];
        $product -> is_hide = $validatedData['isHide'];
        $product -> category_id = $validatedData['categoryId'];
        $product -> product_shape_id = $validatedData['productShapeId'];
        $product -> product_style_id = $validatedData['productStyleId'];
        $product -> updated_at = now();
        $product -> save();

        $variants = [];
        foreach($validatedData['productVariant'] as $variantData){
            $variant = new ProductVariant();

            if (isset($variantData['productVariantId'])) {
                $existingVariant = ProductVariant::find($variantData['productVariantId']);
                if ($existingVariant !== null) {
                    $variant = $existingVariant;
                }
            }
            $variant->product_id = $product->product_id;
            $variant -> height = $variantData['height'];
            $variant -> width = $variantData['width'];
            $variant -> quantity = $variantData['quantity'];
            $variant -> price = $variantData['price'];

            if(isset($variantData['color'])){
                if($variantData['color']['colorId'] != null && isset($variantData['color']['colorId'])){
                    $variant -> color_id = $variantData['color']['colorId'];
                } else {
                    $color = new ProductColor();
                    $color -> color_name = $variantData['color']['colorName'];
                    $color -> save();
                    $variant -> color_id = $color -> product_color_id;
                }
            }
            if(isset($variantData['imageUrl'])){
                $image = new Image();
                $image -> image_url = $variantData['imageUrl'];
                $image -> save();
                $variant -> image_id = $image -> image_id;
            }
            $variant -> save();
            $variants[] = $variant;
        }
    
        return response()->json([
            'message' => 'Product updated successfully.',
            'product' => $product,
            'variants' => $variants,
            'imageUrl' => $validatedData['imageUrl']
        ], 201);
    }

}
