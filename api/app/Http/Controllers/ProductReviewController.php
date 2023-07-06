<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index()
    {
        $productReviews = ProductReview::with('account', 'product')->get();

        return response()->json([
            'product_reviews' => $productReviews,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_id' => 'required',
            'product_id' => 'required',
            'content' => 'required|string',
            'rating' => 'required|integer',
        ]);

        $productReview = ProductReview::create($validatedData);

        if ($productReview) {
            return response()->json([
                'product_review' => $productReview,
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
            'product_review' => $productReview,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'account_id' => 'required',
            'product_id' => 'required',
            'content' => 'required|string',
            'rating' => 'required|integer',
        ]);

        $productReview = ProductReview::findOrFail($id);
        $updated = $productReview->update($validatedData);

        return response()->json($updated);
    }

    public function destroy($id)
    {
        $productReview = ProductReview::findOrFail($id);
        $deleted = $productReview->delete();

        return response()->json($deleted);
    }
}
