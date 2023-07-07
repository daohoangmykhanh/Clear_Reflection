<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::all();
        $cartData = [];

        foreach ($carts as $cart) {
            $cartData[] = [
                'cartId' => $cart->cart_id,
                'accountId' => $cart->account_id,
            ];
        }

        return response()->json([
            'carts' => $cartData,
        ]);
    }


    public function show($cartId)
    {
        $cart = Cart::findOrFail($cartId);

        return response()->json([
            'cart' => [
                'cartId' => $cart->cart_id,
                'accountId' => $cart->account_id,

            ]
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_id' => 'required|integer',
        ]);

        $cart = Cart::create($validatedData);

        return response()->json([
            'cart' => [
                'cartId' => $cart->cart_id,
                'accountId' => $cart->account_id,

            ]
        ], 201);
    }

    public function update(Request $request, $cartId)
    {
        $validatedData = $request->validate([
            'account_id' => 'required|integer',
        ]);

        $cart = Cart::findOrFail($cartId);
        $updated = $cart->update($validatedData);

        if ($updated) {
            return response()->json([
                'result' => true,
                'message' => 'Cart updated successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to update cart.',
            ]);
        }
    }

    public function destroy($cartId)
    {
        $cart = Cart::find($cartId);

        if (!$cart) {
            return response()->json([
                'result' => false,
                'message' => 'Cart not found.',
            ]);
        }

        $deleted = $cart->delete();

        if ($deleted) {
            return response()->json([
                'result' => true,
                'message' => 'Cart deleted successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete cart.',
            ]);
        }
    }
}
