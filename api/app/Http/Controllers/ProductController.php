<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $paginationLimit = 10; // Number of products per page

        $products = Product::with('category', 'product_shape', 'product_style', 'images', 'variants')
            ->paginate($paginationLimit);

        $productData = [];

        foreach ($products as $product) {
            $imageData = [];
            foreach ($product->images as $image) {
                $imageData[] = [
                    'imageId' => $image->image_id,
                    'imageUrl' => $image->image->image_url
                ];
            }
            $productData[] = [
                'productId' => $product->product_id,
                'productName' => $product->product_name,
                'description' => $product->description,
                'isHide' => $product->is_hide,
                'imageUrls' => $imageData,
                'category' => $product->category->category_name ?? null,
                'productShapeName' => $product->product_shape->shape_name ?? null,
                'productStyleName' => $product->product_style->style_name ?? null,
            ];
        }

        return response()->json([
            'products' => $productData,
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }



    public function show($id)
    {
        $product = Product::with('category', 'product_shape', 'product_style', 'images', 'variants')->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found.',
            ], 404);
        }

        return response()->json([
            'product' =>  [
                'productId' => $product->product_id,
                'productName' => $product->product_name,
                'description' => $product->description,
                'isHide' => $product->is_hide,
                'category' => $product->category->category_name ?? null,
                'productShape' => $product->product_shape->shape_name ?? null,
                'productStyle' => $product->product_style->style_name ?? null,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string',
            'description' => 'nullable|string',
            'is_hide' => 'boolean',
            'category_id' => 'integer',
            'product_shape_id' => 'integer',
            'product_style_id' => 'integer',
        ]);

        $product = Product::create($validatedData);

        return response()->json([
            'product' => [
                'productId' => $product->product_id,
                'productName' => $product->product_name,
                'description' => $product->description,
                'isHide' => $product->is_hide,
                'categoryId' => $product->category_id,
                'productShapeId' => $product->product_shape_id,
                'productStyleId' => $product->product_style_id,
            ]
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_name' => 'string',
            'description' => 'nullable|string',
            'is_hide' => 'boolean',
            'category_id' => 'integer',
            'product_shape_id' => 'integer',
            'product_style_id' => 'integer',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'result' => false,
                'message' => 'Product not found.',
            ]);
        }

        $updated = $product->update($validatedData);

        if ($updated) {
            return response()->json([
                'result' => true,
                'message' => 'Product updated successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to update product.',
            ]);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'result' => false,
                'message' => 'Product not found.',
            ]);
        }

        $deleted = $product->delete();

        if ($deleted) {
            return response()->json([
                'result' => true,
                'message' => 'Product deleted successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete product.',
            ]);
        }
    }

    public function sortByRating(Request $request, $order)
    {
        $products = Product::with(['category', 'product_shape', 'product_style', 'images', 'variants', 'reviews'])
            ->leftJoin('product_review', 'product.product_id', '=', 'product_review.product_id')
            ->orderBy('product_review.rating', $order)
            ->get();

        $productData = [];

        foreach ($products as $product) {
            $productData[] = [
                'productId' => $product->product_id,
                'productName' => $product->product_name,
                'description' => $product->description,
                'isHide' => $product->is_hide,
                'category' => $product->category->category_name ?? null,
                'productShapeName' => $product->product_shape->shape_name ?? null,
                'productStyleName' => $product->product_style->style_name ?? null,
            ];
        }

        return response()->json([
            'products' => $productData,
        ]);
    }


    public function getLatestProducts()
    {
        // Lấy 8 sản phẩm mới nhất dựa trên ngày tạo (hoặc trường khác tương ứng)
        $latestProducts = Product::latest()->take(4)->get();

        // Trả về danh sách sản phẩm mới nhất dưới dạng JSON
        return response()->json($latestProducts);
    }
    public function filterByCategory($categoryId)
    {
        $products = Product::with('category')
            ->whereHas('category', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->get();
        $productData = [];

        foreach ($products as $product) {
            $imageData = [];
            foreach ($product->images as $image) {
                $imageData[] = [
                    'imageId' => $image->image_id,
                    'imageUrl' => $image->image->image_url
                ];
            }
            $productData[] = [
                'productId' => $product->product_id,
                'productName' => $product->product_name,
                'description' => $product->description,
                'isHide' => $product->is_hide,
                'imageUrls' => $imageData,
                'category' => $product->category->category_name ?? null,
                'productShapeName' => $product->product_shape->shape_name ?? null,
                'productStyleName' => $product->product_style->style_name ?? null,
            ];
        }

        return response()->json($productData);
    }
}
