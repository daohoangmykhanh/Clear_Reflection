<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'accountId' => 'required|integer',
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
            'accountId' => 'required|integer',
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

    public function getCartQuantity()
    {
        $cartQuantity = 0;

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (Auth::check()) {
            // Lấy giỏ hàng của người dùng đăng nhập
            $cart = Auth::user()->cart;
            // Kiểm tra xem giỏ hàng có tồn tại hay không
            if ($cart) {
                // Đếm tổng số lượng sản phẩm trong giỏ hàng
                $cartQuantity = $cart->cartDetails->sum('quantity');
            }
        }

        // Trả về số lượng sản phẩm trong giỏ hàng dưới dạng JSON
        return response()->json(['quantity' => $cartQuantity]);
    }
}
