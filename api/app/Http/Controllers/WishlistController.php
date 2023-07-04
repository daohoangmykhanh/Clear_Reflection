<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('account', 'product')->get();

        return response()->json($wishlists);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_id' => 'required',
            'product_id' => 'required',
        ]);

        $wishlist = Wishlist::create($validatedData);

        if ($wishlist) {
            return response()->json($wishlist, 201);
        } else {
            return response()->json(['message' => 'Thêm wishlist thất bại'], 500);
        }
    }

    public function show($id)
    {
        $wishlist = Wishlist::with('account', 'product')->findOrFail($id);

        return response()->json($wishlist);
    }

    public function update(Request $request, $id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $wishlist->update($request->all());

        if ($wishlist) {
            return response()->json(['message' => 'Cập nhật wishlist thành công']);
        } else {
            return response()->json(['message' => 'Cập nhật wishlist thất bại'], 500);
        }
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $wishlist->delete();

        return response()->json(['message' => 'Xóa wishlist thành công']);
    }
}
