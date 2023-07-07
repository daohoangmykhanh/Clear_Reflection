<?php

namespace App\Http\Controllers;

use App\Models\CartDetail;
use App\Models\Image;
use App\Models\Order;
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
        $products = Product::with('images')->get();
        if ($products->isEmpty()) {
            return response()->json([
                'result' => false,
                'message' => "No results found!",
            ]);
        }
        $productData = [];
        foreach ($products as $product) {
            $imageData = null;
            if ($product->images !== null) {
                foreach ($product->images as $image) {
                    if ($image->image_id !== null) {
                        $imageData[] = [
                            'imageId' => $image->image_id,
                            'imageUrl' => $image->image_url,
                        ];
                    }
                }
            }
            $orders = OrderDetail::where('product_id',$product -> product_id) -> get();
            $sold = 0;
            if($orders -> isNotEmpty()){
                foreach($orders as $order){
                    $sold += $order -> quantity;
                }
            }
            $ratings = ProductReview::where('product_id',$product -> product_id) -> get();
            $count = ProductReview::where('product_id',$product -> product_id) -> get() ->count();
            $ratingStar = 0;
            $star = 0;
            if($count != 0){
                foreach($ratings as $rating){
                    $star += $rating -> rating;
                }
                $ratingStar = $star / $count;
            }
            $likes = 0;
            $wishes = Wishlist::where('product_id',$product -> product_id) -> get();
            if($wishes -> isNotEmpty()){
                foreach($wishes as $wish){
                    $likes += 1;
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
                'images' => $imageData,
                'category' => $category,
                'productShape' => $shape,
                'productStyle' => $style,
                'sold' => $sold,
                'ratingStar' => $ratingStar,
                'likes' => $likes,
                'createdAt' => $product->created_at,
                'updatedAt' => $product->updated_at,
            ];
        }
        return response()->json($productData);
    }

    public function detail($id)
    {
        $product = Product::with('images')->find($id);
        if ($product == null) {
            return response()->json('No results found!');
        }
        $imageData = null;
        if( $product -> images !== null){
            foreach ($product->images as $image) {
                $imageData[] = [
                    'imageId' => $image -> image_id,
                    'imageUrl' => $image -> image_url
                ];
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
        $totalQuantity = 0;
        $totalRating = ProductReview::where('product_id',$id) -> get() -> count();
        $totalLove = Wishlist::where('product_id', $id) -> get() -> count();
        $ratings = ProductReview::where('product_id',$id) -> get();
        $star = 0;
        $count = 0;
        foreach($ratings as $rating){
            $star += $rating -> rating;
            $count ++;
        }
        if($count != 0){
            $ratingStar = $star / $count;
        } else {
            $ratingStar = 0;
        }
        $variantData = null;
        foreach ($product->variants as $variant) {
            $color = $variant->color;
            $image = null;
            if($variant -> image !== null){
                $image = [
                    'imageId' => $variant -> image -> image_id,
                    'imageUrl' => $variant -> image -> image_url
                ];
            }
            $variantData[] = [
                'height' => $variant->height,
                'width' => $variant->width,
                'color' => [
                    'colorId' => $color -> product_color_id,
                    'colorName' => $color -> color_name
                ],
                'quantity' => $variant->quantity,
                'price' => $variant->price,
                'image' => $image
            ];
            $totalQuantity += $variant -> quantity;
        }
        $productData[] = [
            'product_id' => $product->product_id,
            'product_name' => $product->product_name,
            'description' => $product->description,
            'isHide' => $product->is_hide,
            'images' => $imageData,
            'category' => $category,
            'productShape' => $shape,
            'productStyle' => $style,
            'productVariant' => $variantData,
            'createdAt' => $product->created_at,
            'updatedAt' => $product->updated_at,
            'totalQuantity' => $totalQuantity,
            'ratingStar' => $ratingStar,
            'totalRating' => $totalRating,
            'totalLove' => $totalLove
        ];
        return response()->json($productData);
    }

    public function hide($id){
        $product = Product::Find($id);
        if($product == null)
            return response()-> json([
                'result' => false,
                'message' => "Product doesnt exist!",
            ]);
        $product -> is_hide = false;
        return response()-> json([
            'result' => true,
            'message' => "Product was hidden!",
        ]);
    }
    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'productName' => 'required|unique:product,product_name',
                'description' => 'nullable|string',
                'categoryId' => 'nullable|integer',
                'productShapeId' => 'nullable|integer',
                'productStyleId' => 'nullable|integer',
                'productVariant' => 'required|array',
                'imageUrl' => 'required|array',
                'productVariant.*.height' => 'required|numeric',
                'productVariant.*.width' => 'required|numeric',
                'productVariant.*.color.colorId' => 'nullable|integer',
                'productVariant.*.color.colorName' => 'required|string',
                'productVariant.*.quantity' => 'required|integer',
                'productVariant.*.price' => 'required|numeric',
                'productVariant.*.imageUrl' => 'nullable|string',
            ]);

            $product = new Product();
            $product-> product_name = $validatedData['productName'];
            $product -> description = $validatedData['description'];
            $product -> is_hide = true;
            $product -> category_id = $validatedData['categoryId'];
            $product -> product_shape_id = $validatedData['productShapeId'];
            $product -> product_style_id = $validatedData['productStyleId'];
            $product -> created_at = now();
            $product -> save();

            foreach($validatedData['images'] as $image){
                $image = new Image();
                $base64String = $image;
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
            foreach($validatedData['productVariants'] as $variantData){
                $variant = new ProductVariant();
                $variant -> product_id = $product->product_id;
                $variant -> height = $variantData['height'];
                $variant -> width = $variantData['width'];
                $variant -> quantity = $variantData['quantity'];
                $variant -> price = $variantData['price'];

                if(isset($variantData['color'])){
                    if($variantData['color']['productColorId'] != null){
                        $variant -> color_id = $variantData['color']['productColorId'];
                    } else {
                        $color = new ProductColor();
                        $color -> color_name = $variantData['color']['colorName'];
                        $color -> save();
                        $variant -> color_id = $color -> product_color_id;
                    }
                }
                if(isset($variantData['image'])){
                    $image = new Image();
                    $base64String = $variantData['image'];
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
                'images' => $validatedData['images']
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => $e->errors(),
            ], 422);
        }
    }

    public function edit ($id){
        $product = Product::Find($id) -> with('images') ;
        if(!$product){
            return response()->json([
                'result' => false,
                'message' => "No results found!",
            ]);
        }
        $productData = [];
        $imageData = [];
        foreach($product -> images as $image){
            $imageData[] = [
                'imageId' => $image -> image_id,
                'imageUrl' => $image -> image_url
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
                'productVariantId' => $variant->product_variant_id,
                'height' => $variant->height,
                'width' => $variant->width,
                'color' => [
                    'productColorId' => $color->product_color_id,
                    'colorName' => $color->color_name
                ],
                'quantity' => $variant->quantity,
                'price' => $variant->price,
                'image' => $image ? [  // Use a conditional check for $variant->image
                    'imageId' => $image->image_id,
                    'imageUrl' => $image->image_url
                ] : null  // If $variant->image is null, set the image key to null
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
            'productVariants' => $variantData,
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
                'productName' => 'required|unique:product,product_name,'. $id . ',product_id',
                'description' => 'nullable|string',
                'isHide' => 'required|boolean',
                'categoryId' => 'required|integer',
                'productShapeId' => 'required|integer',
                'productStyleId' => 'required|integer',
                'productVariants' => 'required|array',
                'images' => 'required|array',
                'productVariants.*.height' => 'required|numeric',
                'productVariants.*.productVariantId' => 'nullable|integer',
                'productVariants.*.width' => 'required|numeric',
                'productVariants.*.color.productColorId' => 'nullable|integer',
                'productVariants.*.color.colorName' => 'nullable|string',
                'productVariants.*.quantity' => 'required|integer',
                'productVariants.*.price' => 'required|numeric',
                'productVariants.*.image' => 'nullable|string',
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
            foreach($validatedData['productVariants'] as $variantData){
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
                    if(isset($variantData['color']['productColorId'])){
                        $variant -> color_id = $variantData['color']['productColorId'];
                    } else {
                        $color = new ProductColor();
                        $color -> color_name = $variantData['color']['colorName'];
                        $color -> save();
                        $variant -> color_id = $color -> product_color_id;
                    }
                }
                if(isset($variantData['image'])){
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
                    $base64String = $variantData['image'];
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
