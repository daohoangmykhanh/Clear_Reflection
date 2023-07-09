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
            'addressId' => 'nullable',
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

        if(isset($validatedData['addressId'])){
            $address = Address::find($validatedData['addressId']);
        } else {
            $address = new Address();
            $check = Address::all() -> count();
            $lastAddress = null;
            if($check > 0){
                $lastAddress = Address::orderBy('address_id', 'desc')->first();
                $address -> address_id = $lastAddress ->address_id + 1;
            } else {
                $address -> address_id = 1;
            }
        }

        $address -> road_name = $validatedData['roadName'];
        $address -> wards_code = $validatedData['wardCode'];
        $address -> district_code = $validatedData['districtCode'];
        $address -> province_code = $validatedData['provinceCode'];
        $address -> save();

        if(isset($validatedData['addressId'])){
            $order -> address_id = $validatedData['addressId'];
        } else {
            $check = Address::all() -> count();
            if($check > 0){
                $order -> address_id = $lastAddress ->address_id + 1;
            } else {
                $order -> address_id = 1;
            }
        }
        $order -> save();

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

        $redirectUrl = url('/api/vnpay');
        $redirectUrl .= '?orderId=' . $order->order_id . '&totalPrice=' . $order->total_price;
        return redirect()->away($redirectUrl);
    }

    public function vnpay(Request $request){
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "https://localhost/vnpay_php/vnpay_return.php";
        $vnp_TmnCode = "9UK2UJNR";
        $vnp_HashSecret = "QGAXNJNTKZCPFWBRTDTVHMZWEMZCOCCM";

        $vnp_TxnRef = $request->input('orderId');
        $vnp_OrderInfo = 'Test payment';
        $vnp_OrderType = 'billpayemnt';
        $vnp_Amount = $request->input('totalPrice') * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];


        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
    }


}
