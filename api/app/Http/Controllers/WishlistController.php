<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::all();
        $wishlistData = [];

        foreach ($wishlists as $wishlist) {
            $product = $wishlist->product;
            $account = $wishlist->account;

            $wishlistData[] = [
                'wishlist_id' => $wishlist->wishlist_id,
                'account' => [
                    'account_id' => $account->account_id,
                    'account_name' => $account->account_name,
                    // Add other account fields as needed
                ],
                'product' => [
                    'product_id' => $product->product_id,
                    'product_name' => $product->product_name,
                    // Add other product fields as needed
                ],
                'created_at' => $wishlist->created_at,
                'updated_at' => $wishlist->updated_at,
            ];
        }

        return response()->json($wishlistData);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_id' => 'required',
            'product_id' => 'required',
        ]);

        $wishlist = Wishlist::create($validatedData);

        return response()->json($wishlist, 201);
    }

    public function show($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $product = $wishlist->product;
        $account = $wishlist->account;

        $wishlistData = [
            'wishlist_id' => $wishlist->wishlist_id,
            'account' => [
                'account_id' => $account->account_id,
                'account_name' => $account->account_name,
                // Add other account fields as needed
            ],
            'product' => [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                // Add other product fields as needed
            ],
            'created_at' => $wishlist->created_at,
            'updated_at' => $wishlist->updated_at,
        ];

        return response()->json($wishlistData);
    }

    public function update(Request $request, $id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $wishlist->update($request->all());

        return response()->json($wishlist);
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $wishlist->delete();

        return response()->json(['message' => 'Wishlist deleted']);
    }
}
