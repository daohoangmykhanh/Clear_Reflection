<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductColor;
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
                        'color_id' => $color -> product_color_id,
                        'color_name' => $color -> color_name
                    ],
                    'quantity' => $variant->quantity, 
                    'price' => $variant->price,
                    'image' => [
                        'image_id' => $image -> image_id,
                        'image_name' => $image -> image_name
                    ]
                ];
            }
            $productData[] = [
                'product_id' => $product->product_id,
                'product_name' => $product -> product_name,
                'description' => $product->description,
                'is_hide' => $product->is_hide,
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

    public function create (Request $request){
        $validatedData = $request->validate([
            'product_name' => 'required|string',
            'product_variant' => 'required|array',
            'product_variant.*' => 'required|string'
        ]);

        $product = new Product();
        $product-> product_name = $validatedData['product_name'];
        $product -> description = $validatedData['description'];
        $product -> is_hide = $validatedData['is_hide'];
        $product -> product_shape_id = $validatedData['product_shape_id'];
        $product -> product_style_id = $validatedData['product_style_id'];
        $product -> created_at = now();
        $product -> save();
        
        $variants = [];

        foreach($validatedData['product_variant'] as $variantData){
            $variant = new ProductVariant();
            $variant -> product_id = $product->product_id;
            $variant -> height = $variantData['height'];
            $variant -> width = $variantData['width'];
            $variant -> color_id = $variantData['color_id'];
            $variant -> quantity = $variantData['quantity'];
            $variant -> price = $variantData['price'];

            if(isset($variantData['color_name'])){
                $color = new ProductColor();
                $color -> color_name = $variantData['color_name'];
                $color -> save();
                $variant -> color_id = $color -> product_color_id;
            }
            if(isset($variantData['color_id'])){
                $variant -> color_id = $validatedData['color_id'];
            }

            if(isset($variantData['image_url'])){
                $image = new Image();
                $image -> image_url = $variantData['image_url'];
                $image -> save();
                $variant -> image_id = $image -> image_id;
            }
            $variants[] = $variant;
        }
        $product->variants()->saveMany($variants);

        return response()->json('Created successfully !', 201);
    }


}
