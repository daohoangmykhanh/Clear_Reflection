<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::all();

        return response()->json([
            'carts' => $carts,
        ]);
    }

    public function show($cartId)
    {
        $cart = Cart::findOrFail($cartId);

        return response()->json([
            'cart' => $cart,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_id' => 'required|integer',
        ]);

        $cart = Cart::create($validatedData);

        return response()->json([
            'message' => 'Cart created successfully.',
            'cart' => $cart,
        ], 201);
    }

    public function update(Request $request, $cartId)
    {
        $validatedData = $request->validate([
            'account_id' => 'required|integer',
        ]);

        $cart = Cart::findOrFail($cartId);
        $cart->update($validatedData);

        return response()->json([
            'message' => 'Cart updated successfully.',
            'cart' => $cart,
        ]);
    }

    public function destroy($cartId)
    {
        $cart = Cart::findOrFail($cartId);
        $cart->delete();

        return response()->json([
            'message' => 'Cart deleted successfully.',
        ]);
    }
}
