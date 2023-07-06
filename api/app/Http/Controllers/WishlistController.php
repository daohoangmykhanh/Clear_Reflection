<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('account', 'product')->get();

        return response()->json([
            'wishlists' => $wishlists,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_id' => 'required',
            'product_id' => 'required',
        ]);

        $wishlist = Wishlist::create($validatedData);

        if ($wishlist) {
            return response()->json([
                'wishlist' => $wishlist,
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed to create wishlist.',
            ], 500);
        }
    }


    public function show($id)
    {
        $wishlist = Wishlist::with('account', 'product')->findOrFail($id);

        return response()->json([
            'wishlist' => $wishlist,
        ]);
    }

    public function update(Request $request, $id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $updated = $wishlist->update($request->all());

        return response()->json($updated);
    }


    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $deleted = $wishlist->delete();

        return response()->json($deleted);
    }
}
