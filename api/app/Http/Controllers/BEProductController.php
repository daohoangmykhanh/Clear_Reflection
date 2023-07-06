<?php

namespace App\Http\Controllers;

use App\Models\CartDetail;
use App\Models\Image;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\ProductVariant;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
            $imageData = null;
            if ($product->images !== null) {
                foreach ($product->images as $image) {
                    if ($image->image !== null) {
                        $imageData[] = [
                            'imageId' => $image->image_id,
                            'imageUrl' => $image->image->image_url,
                        ];
                    }
                }
            }
            $category = null;
            if ($product->category_id !== null) {
                $category = [
                    'categoryId' => $product->category -> category_id,
                    'categoryName' => $product->category ->category_name,
                ];
            }
            $shape = null;
            if ($product->product_shape_id !== null) {
                $shape = [
                    'productShapeId' => $product->product_shape_id,
                    'shapeName' => $product->product_shape->shape_name,
                ];
            }
            $style = null;
            if ($product->product_style_id !== null) {
                $style =[
                    'productStyleId' => $product->product_style_id,
                    'styleName' => $product->product_style->style_name,
                ];
            }
       

            $productData[] = [
                'productId' => $product->product_id,
                'productName' => $product -> product_name,
                'description' => $product->description,
                'isHide' => $product->is_hide,
                'imageUrls' => $imageData,
                'category' => $category,
                'productShape' => $shape,
                'productStyle' => $style,
                'createdAt' => $product->created_at,
                'updatedAt' => $product->updated_at,
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
                    'imageId' => $image -> image_id,
                    'imageUrl' => $image -> image -> image_url
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
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
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

    public function create(Request $request)
    {
        try {
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
                $base64String = $imageUrl;
                $base64Data = substr($base64String, strpos($base64String, ',') + 1);
                $imageData = base64_decode($base64Data);
                $filename = uniqid() . '.png'; 
                $storagePath = public_path('images/product/');
                file_put_contents($storagePath. $filename, $imageData);
                $image->image_url = $filename;
                $image->save();
                $productImage = new ProductImage();
                $productImage->image_id = $image->image_id;
                $productImage->product_id = $product->product_id;
                $productImage->save();
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
                    $base64String = $variantData['imageUrl']; 
                    $base64Data = substr($base64String, strpos($base64String, ',') + 1);
                    $imageData = base64_decode($base64Data);
                    $filename = uniqid() . '.png'; 
                    $storagePath = public_path('images/product/');
                    file_put_contents($storagePath. $filename, $imageData);
                    $image->image_url = $filename;
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
        } catch (ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => $e->errors(),
            ], 422);
        }
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
        if($product == null)
            return response()->json([
                'result' => false,
                'message' => 'Product doesnt exist!'
            ]);
        try {   
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
                    if($variant -> image_id != null){
                        $oldImageFilename = $variant -> image -> image_url;
                        $oldImagePath = public_path('images/product/') . $oldImageFilename;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                        $image = Image::find($variant->image_id);
                    } else {
                        $image = new Image();
                    }
                    $base64String = $variantData['imageUrl'];
                    $base64Data = substr($base64String, strpos($base64String, ',') + 1);
                    $imageData = base64_decode($base64Data);
                    $filename = uniqid() . '.png'; 
                    $storagePath = public_path('images/product/');
                    file_put_contents($storagePath. $filename, $imageData);
                    $image -> image_url = $filename; 
                    $image -> save();
                    $variant -> image_id = $image -> image_id;
                }
                $variant -> save();
                $variants[] = $variant;
            }


            return response()->json([
                'result' => true,
                'message' => "Updated product successfully",
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => $e->errors(),
            ], 422);
        }
    }

    public function delete($id){
        $product = Product::Find($id);
        if($product == null){
            return response()-> json([
                'result' => false,
                'message' => "Product doesnt exist!",
            ]);
        }
        $images = ProductImage::where('product_id', $id) -> get();
        if($images -> isNotEmpty()){
            foreach($images as $image){
                $img = Image::find($image->image_id);
                $oldImageFilename = $img -> image_url;
                $oldImagePath = public_path('images/product/') . $oldImageFilename;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                $image->delete();
                $img -> delete();
            }
         }
        $variants = ProductVariant::where('product_id', $id) -> get();
        if($variants -> isNotEmpty()){
           foreach($variants as $variant){
                $img = Image::find($variant->image_id);
                $oldImageFilename = $img -> image_url;
                $oldImagePath = public_path('images/product/') . $oldImageFilename;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                $variant->delete();
                $img -> delete();
           }
        }
        $carts = CartDetail::where('product_id', $id) -> get();
        if($carts -> isNotEmpty()){
            foreach($carts as $cart){
                $cart->delete();
            }
         }
        $wishlists = Wishlist::where('product_id', $id) -> get();
        if($variants -> isNotEmpty()){
            foreach($wishlists as $wishlist){
                $wishlist->delete();
            }
         }
        $reviews = ProductReview::where('product_id', $id) -> get();
        if($reviews -> isNotEmpty()){
            foreach($reviews as $review){
                 $review->delete();
            }
        }
        $orders = OrderDetail::where('product_id', $id) -> get();
        if($orders -> isNotEmpty()){
            foreach($orders as $order){
                $order-> product_id = null;
                $order -> save();
            }
        }
        $delete = $product -> delete();
        if(!$delete){
            return response()->json([
                'result' => false,
                'message' => "Deleted product unsuccessfully!",
            ]);
        }
        return response()->json([
                'result' => true,
                'message' => "Deleted product successfully!",
            ]);
        
    }
}
