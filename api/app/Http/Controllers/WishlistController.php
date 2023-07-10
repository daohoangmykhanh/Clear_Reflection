<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('account', 'product')->get();
        $wishlistData = [];

        foreach ($wishlists as $wishlist) {
            $wishlistData[] = [
                'wishlistId' => $wishlist->wishlist_id,
                'accountId' => $wishlist->account_id,
                'productId' => $wishlist->product_id,
            ];
        }

        return response()->json($wishlistData);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'accountId' => 'required',
            'productId' => 'required',
        ]);

        $wishlist = Wishlist::create($validatedData);
        $wishlistData[] = [
            'wishlistId' => $wishlist->wishlist_id,
            'accountId' => $wishlist->account_id,
            'productId' => $wishlist->product_id,
        ];
        if ($wishlistData) {
            return response()->json($wishlistData, 201);
        } else {
            return response()->json(['message' => 'Thêm wishlist thất bại'], 500);
        }
    }

    public function show($id)
    {
        $wishlist = Wishlist::with('account', 'product')->findOrFail($id);
        $wishlistData = [
            'wishlistId' => $wishlist->wishlist_id,
            'accountId' => $wishlist->account_id,
            'productId' => $wishlist->product_id
        ];
        return response()->json($wishlistData);
    }

    public function update(Request $request, $id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $updated = $wishlist->update($request->all());

        return response()->json([
            'result' => $updated ? true : false,
            'message' => $updated ? 'Wishlist updated successfully.' : 'Failed to update wishlist.',
        ]);
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $deleted = $wishlist->delete();

        return response()->json([
            'result' => $deleted ? true : false,
            'message' => $deleted ? 'Wishlist deleted successfully.' : 'Failed to delete wishlist.',
        ]);
    }

    public function removeFromWishList($product_id)
    {
        try {
            $wishlist = Wishlist::where('product_id', $product_id)->first();
            $deleted = $wishlist->delete();
            return response()->json([
                'result' => $deleted ? true : false,
                'message' => $deleted ? 'Wishlist deleted successfully.' : 'Failed to delete wishlist.',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to remove from wishlist']);
        }
    }
}
