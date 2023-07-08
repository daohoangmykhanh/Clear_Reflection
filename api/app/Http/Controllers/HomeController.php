<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{

    public function checkout(Request $request)
    {
        $validatedData = $request->validate([
            'accountId' => 'required|integer',
            'couponId' => 'nullable|integer',
            'totalPrice' => 'required|numeric',
            'totalQuantity' => 'required|numeric',
            'orderStatusId' => 'required|integer',
            'paymentMethodId' => 'required|integer',
            'houseNumber' => 'required',
            'roadName' => 'required',
            'wardCode' => 'required',
            'districtCode'=> 'required',
            'provinceCode' => 'required',
        ]);

        $order = new Order();
        $order -> account_id = $validatedData['accountId'];
        $order -> coupon_id = $validatedData['couponId'] ?? null;
        $order -> total_price = $validatedData['totalPrice'];
        $order -> total_quantity = $validatedData['totalQuantity'];
        $order -> order_status_id = $validatedData['orderStatusId'];
        $order -> payment_method_id = $validatedData['paymentMethodId'];
        $order -> created_at = now();
        $order -> save();
        $order -> order_tracking_number = "ML10".$order -> order_id."TY";
        $order -> save();

        $address = new Address();
        $check = Address::all() -> count();
        $lastAddress = null;
        if($check > 0){
            $lastAddress = Address::orderBy('address_id', 'desc')->first();
            $address -> address_id = $lastAddress ->address_id + 1;
        } else {
            $address -> address_id = 1;
        }
        $address -> house_number = $validatedData['houseNumber'];
        $address -> road_name = $validatedData['roadName'];
        $address -> wards_code = $validatedData['wardCode'];
        $address -> district_code = $validatedData['districtCode'];
        $address -> province_code = $validatedData['provinceCode'];
        $address -> save();

        $shipping = new OrderAddress();
        if($check > 0){
            $shipping -> address_id = $lastAddress ->address_id + 1;
        } else {
            $shipping -> address_id = 1;
        }
        $shipping -> order_id = $order -> order_id;
        $shipping -> save();

        $cart = Cart::where('account_id', $validatedData['accountId']) -> first();
        $cartDetails = CartDetail::where('cart_id', $cart->cart_id) -> get();
        foreach($cartDetails as $cartDetail){
            $orderDetail = new OrderDetail();

            $variant = ProductVariant::find($cartDetail -> variant -> product_variant_id);
            $quantity = $cartDetail -> variant -> quantity - $cartDetail -> quantity;
            $product = Product::find($variant -> product_id);
            $orderDetail -> product_name = $product -> product_name;
            $orderDetail -> order_id = $order -> order_id;
            $orderDetail -> product_id = $variant -> product_id;
            $orderDetail -> color = $variant -> color -> color_name;
            $orderDetail -> height = $variant -> height;
            $orderDetail -> width = $variant -> width;
            $orderDetail -> quantity = $cartDetail -> quantity;
            $orderDetail -> price = $variant -> price;
            $orderDetail -> save();
            $variant -> quantity = $quantity;
            $variant -> save();
            $cartDetail -> delete();
        }

        return response()->json([
            'result' => true,
            'message' => 'Checkout successfully!'
        ]);

    }

    public function profile(){

    }


}
