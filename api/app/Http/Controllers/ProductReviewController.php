<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index()
    {
        $productReviews = ProductReview::with('account', 'product')->get();

        return response()->json($productReviews);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_id' => 'required',
            'product_id' => 'required',
            'content' => 'required|string',
            'rating' => 'required|integer',
        ]);

        try {
            $productReview = ProductReview::create($validatedData);
            return response()->json($productReview, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Thêm product review thất bại'], 500);
        }
    }

    public function show($id)
    {
        $productReview = ProductReview::with('account', 'product')->findOrFail($id);

        return response()->json($productReview);
    }

    public function update(Request $request, $id)
    {
        $productReview = ProductReview::findOrFail($id);
        $productReview->update($request->all());

        if ($productReview) {
            return response()->json(['message' => 'Cập nhật product review thành công']);
        } else {
            return response()->json(['message' => 'Cập nhật product review thất bại'], 500);
        }
    }

    public function destroy($id)
    {
        $productReview = ProductReview::findOrFail($id);
        $productReview->delete();

        return response()->json(['message' => 'Xóa product review thành công']);
    }
}
