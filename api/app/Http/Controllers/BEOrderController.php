<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Product;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class BEOrderController extends Controller
{
    public function index(){
        $orders = Order::all();
        if($orders -> isEmpty()){
            return response()->json('No results found!');
        }
        foreach($orders as $order){

            $orderData[] = [
                'order_id' => $order->order_id,
                'order_tracking_number' => $order->order_tracking_number,
                'total_price' => $order->total_price,
                'total_quantity' => $order->total_quantity,
                'order_status' => [
                    'order_status_id' => $order->status -> order_status_id,
                    'status_name' => $order->status ->status_name
                ],
                'payment_method' => [
                    'payment_method_id' => $order->payment-> payment_method_id,
                    'payment_method_name' => $order->payment->payment_method_name,
                ],
                'created_at' => $order->created_at,
            ];
        }
        return response()->json($orderData);
    }

    public function detail($id){
        $order = Order::find($id);
        if($order == null){
            return response()->json('Order doesnt exist!');
        }
        if($order -> coupon_id != null){
            $coupon = $order -> coupon -> code;
        } else {
            $coupon = 'NONE';
        }
        $details = OrderDetail::where('order_id',$id) -> get();
        foreach($details as $detail){
            $productData[] = [
                'productId' => $detail -> product_id,
                'productName' => $detail -> product_name,
                'height' => $detail -> height,
                'width' => $detail -> width,
                'price' => $detail -> price,
                'color' => $detail -> color,
                'quantity' => $detail -> quantity
            ];

        }
        $address = OrderAddress::where('order_id',$id) -> first();
        $road = $address -> address -> road_name;
        $house = $address -> address -> house_name;
        $ward = $address -> address -> ward -> full_name_en;
        $district = $address -> address -> district -> full_name_en;
        $province = $address -> address -> province -> full_name_en;
        $shippingAddress = $house.", " . $road .", " . $ward .", " .  $district .", " .  $province;
        $orderData[] = [
            'orderId' => $order->order_id,
            'orderTrackingNumber' => $order->order_tracking_number,
            'account' => [
                'accountId' => $order-> account -> account_id,
                'accountEmail' => $order -> account -> email
            ],
            'products' => $productData,
            'totalPrice' => $order->total_price,
            'totalQuantity' => $order->total_quantity,
            'orderStatus' => [
                'orderStatusId' => $order->status -> order_status_id,
                'statusName' => $order->status ->status_name
            ],
            'couponApplied' => $coupon,
            'paymentMethod' => [
                'paymentMethodId' => $order->payment-> payment_method_id,
                'paymentMethodName' => $order->payment->payment_method_name,
            ],
            'shippingAddress' => $shippingAddress,
            'createdAt' => $order->created_at,

        ];
        return response()->json($orderData);
    }

    public function update(Request $request, $id){
        $order = Order::find($id);
        if($order == null)
            return response()->json([
                'result' => false,
                'message' => 'Order doesn`t exist!',
            ]);
        $validatedData = $request -> validate([
            'orderStatusId' => 'required|integer'
        ]);
        $order -> order_status_id = $validatedData['orderStatusId'];
        $order -> updated_at = now();
        $result = $order -> save();
        if(!$result)
            return response()->json([
                'result' => false,
                'message' => 'Updated unsuccessfully!',
            ]);

        return response()->json([
            'result' => true,
            'message' => 'Updated successfully.',
        ]);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'customerEmail' => 'required|email',
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
            'products' => 'required|array',
            'products.*.productId' => 'required|integer',
            'products.*.height' => 'required|numeric',
            'products.*.width' => 'required|numeric',
            'products.*.color' => 'nullable|integer',
            'products.*.quantity' => 'required|integer',
            'products.*.price' => 'required|numeric'
        ]);
        $order = new Order();
        $account = Account::where('email', $validatedData['customerEmail']) -> first();
        $order -> account_id = $account -> account_id;
        $order -> coupon_id = $validatedData['couponId'] ?? null;
        $order -> total_price = $validatedData['totalPrice'];
        $order -> total_quantity = $validatedData['totalQuantity'];
        $order -> order_status_id = $validatedData['orderStatusId'];
        $order -> payment_method_id = $validatedData['paymentMethodId'];
        $order -> created_at = now();
        $order -> save();

        $lastAddress = Address::latest()->first();
        $address = new Address();
        $address -> address_id = $lastAddress->address_id + 1;
        $address -> house_number = $validatedData['houseNumber'];
        $address -> road_name = $validatedData['roadName'];
        $address -> wards_code = $validatedData['wardCode'];
        $address -> district_code = $validatedData['districtCode'];
        $address -> province_code = $validatedData['provinceCode'];
        $address -> save();

        $shipping = new OrderAddress();
        $shipping -> address_id = $address -> address_id;
        $shipping -> account_id = $account -> account_id;
        $shipping -> save();

        foreach($validatedData['products'] as $productData){
            $detail = new OrderDetail();
            $detail -> order_id = $order -> order_id;
            $detail -> product_id = $productData['productId'];
            $detail -> quantity = $productData['quantity'];
            $detail->height = $productData['height'] ?? null;
            $detail->width = $productData['width'] ?? null;
            $detail->color = $productData['color'] ?? null;
            $detail -> price = $productData['price'];
            $detail -> save();
        }
        return response()->json([
            'result' => true,
            'message' => 'Created successfully.',
        ]);
    }

    public function customerByEmail($keyword){
        $accounts = Account::where('email', 'LIKE', "%{$keyword}%")->where('role_id', 2) -> get();
        if($accounts -> isEmpty())
            return response()->json('No results found!');
        foreach($accounts as $account){
            $image = null;
            if($account -> image_id != null){
                $image = $account -> image -> image_url;
            }
            $accountData[] = [
                'fullName' => $account -> full_name,
                'email' => $account -> email,
                'phoneNumber' => $account -> phone_number,
                'image' => $image
            ];
        }
        return response()->json($accountData);

    }

    public function productByIdOrName($keyword){
        $products = Product::where('product_id', 'LIKE', "%{$keyword}%")
                            -> orWhere('product_name', 'LIKE', "%{$keyword}%")
                            -> where('is_hide', true)
                            -> get();
        if($products -> isEmpty())
            return response()->json('No results found!');
        foreach($products as $product){
            $image = null;
            if($product -> image_id != null){
                $image = $product -> image -> image_url;
            }
            $productData[] = [
                'productId' => $product -> product_id,
                'productName' => $product -> product_name,
                'image' => $image
            ];
        }
        return response()->json($productData);
    }

    public function findAllPayment(){
        $payment = PaymentMethod::all();
        if($payment -> isEmpty())
            return response()->json('No result found!');
        return response()->json($payment);
    }

    public function findAllStatus(){
        $status = OrderStatus::all();
        if($status -> isEmpty())
            return response()->json('No result found!');
        return response()->json($status);
    }
}
