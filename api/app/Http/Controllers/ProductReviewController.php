<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index(Request $request)
    {
        $productReviews = ProductReview::with('account', 'product')->get();
        $productReviewData = [];

        foreach ($productReviews as $productReview) {
            $productReviewData[] = [
                'productReviewId' => $productReview->product_review_id,
                'accountId' => $productReview->account_id,
                'productId' => $productReview->product_id,
                'content' => $productReview->content,
                'rating' => $productReview->rating,
            ];
        }

        return response()->json([
            'product_reviews' => $productReviewData,
        ]);
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'accountId' => 'required',
            'productId' => 'required',
            'content' => 'required|string',
            'rating' => 'required|integer',
        ]);

        $productReview = ProductReview::create($validatedData);

        if ($productReview) {
            return response()->json([
                'product_review' => [
                    'productReviewId' => $productReview->product_review_id,
                    'accountId' => $productReview->account_id,
                    'productId' => $productReview->product_id,
                    'content' => $productReview->content,
                    'rating' => $productReview->rating,
                ]
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed to create product review.',
            ], 500);
        }
    }

    public function show($id)
    {
        $productReview = ProductReview::with('account', 'product')->findOrFail($id);

        return response()->json([
            'product_review' => [
                'productReviewId' => $productReview->product_review_id,
                'accountId' => $productReview->account_id,
                'productId' => $productReview->product_id,
                'content' => $productReview->content,
                'rating' => $productReview->rating,
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'accountId' => 'required',
            'productId' => 'required',
            'content' => 'required|string',
            'rating' => 'required|integer',
        ]);

        $productReview = ProductReview::findOrFail($id);
        $updated = $productReview->update($validatedData);

        if ($updated) {
            return response()->json([
                'result' => true,
                'message' => 'Product review updated successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to update product review.',
            ]);
        }
    }

    public function destroy($id)
    {
        $productReview = ProductReview::findOrFail($id);
        $deleted = $productReview->delete();

        if ($deleted) {
            return response()->json([
                'result' => true,
                'message' => 'Product review deleted successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete product review.',
            ]);
        }
    }

}
