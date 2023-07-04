<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('account', 'cartDetails.product')->get();

        return response()->json($carts);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_id' => 'required',
        ]);

        $cart = Cart::create($validatedData);

        if ($cart) {
            return response()->json($cart, 201);
        } else {
            return response()->json(['message' => 'Thêm cart thất bại'], 500);
        }
    }

    public function show($id)
    {
        $cart = Cart::with('account', 'cartDetails.product')->findOrFail($id);

        return response()->json($cart);
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->update($request->all());

        if ($cart) {
            return response()->json(['message' => 'Cập nhật cart thành công']);
        } else {
            return response()->json(['message' => 'Cập nhật cart thất bại'], 500);
        }
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return response()->json(['message' => 'Xóa cart thành công']);
    }
}
