<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Product;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class BEOrderController extends Controller
{
    public function index(){
        $orders = Order::all();
        if($orders -> isEmpty()){
            return response()->json([
                'result' => true,
                'message' => 'No results found!'
            ]);
        }
        foreach($orders as $order){

            $orderData[] = [
                'orderId' => $order->order_id,
                'totalPrice' => $order->total_price,
                'totalQuantity' => $order->total_quantity,
                'orderStatus' => [
                    'orderStatusId' => $order->status -> order_status_id,
                    'statusName' => $order->status ->status_name
                ],
                'paymentMethod' => [
                    'paymentMethodId' => $order->payment-> payment_method_id,
                    'paymentMethodName' => $order->payment->payment_method_name,
                ],
                'createdAt' => $order->created_at,
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
        $road = $order -> address -> road_name;
        $ward = $order -> address -> ward -> full_name_en;
        $district = $order -> address -> district -> full_name_en;
        $province = $order -> address -> province -> full_name_en;
        $shippingAddress = $road .", " . $ward .", " .  $district .", " .  $province;
        $orderData[] = [
            'orderId' => $order->order_id,
            'account' => [
                'accountId' => $order-> account -> id,
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

    public function findSize($id){
        $products = ProductVariant::where('product_id', $id) -> get();
        foreach ($products as $product){
            $size = $product -> height . 'cmx' . $product -> width . 'cm';
            $sizeData[] = $size;
        }
        return response() -> json($sizeData);
    }

    public function findColor($id, $size){
        $split = array_map('trim', explode('x', $size));
        $height = (int)$split[0];
        $width = (int)$split[1];
        $products = ProductVariant::where('product_id', $id)
                                -> where('height', $height)
                                -> where('width', $width)
                                -> get();
        foreach($products as $product){
            $colorData[] = $product -> color -> color_name;
        }
        return response() -> json($colorData);
    }

    public function findPrice($id, $size, $color){
        $split = array_map('trim', explode('x', $size));
        $height = (int)$split[0];
        $width = (int)$split[1];
        $products = ProductVariant::where('product_id', $id)
                                -> where('height', $height)
                                -> where('width', $width)
                                -> get();
        $price = 0;
        foreach($products as $product){
            if($product -> color -> color_name == $color){
                $price = $product -> price;
            }
        }
        return response() -> json($price);
    }
    public function create(Request $request){
        $validatedData = $request->validate([
            'customerEmail' => 'required|email',
            'couponId' => 'nullable|integer',
            'orderStatusId' => 'required|integer',
            'paymentMethodId' => 'required|integer',
            'roadName' => 'required',
            'wardCode' => 'required',
            'districtCode'=> 'required',
            'provinceCode' => 'required',
            'addressId' => 'nullable',
            'totalPrice' => 'required|numeric',
            'totalQuantity' => 'required|numeric',
            'products' => 'required|array',
            'products.*.productId' => 'required|integer',
            'products.*.size' => 'required',
            'products.*.color' => 'required',
            'products.*.quantity' => 'required|integer',
            'products.*.price' => 'required|numeric'
        ]);
        $order = new Order();
        $account = Account::where('email', $validatedData['customerEmail']) -> first();
        $order -> account_id = $account -> id;
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

        foreach($validatedData['products'] as $productData){
            $split = array_map('trim', explode('x', $productData['size']));
            $height = (int)$split[0];
            $width = (int)$split[1];
            $detail = new OrderDetail();
            $detail -> order_id = $order -> order_id;
            $detail -> product_id = $productData['productId'];
            $product = Product::Find($productData['productId']);
            $detail -> product_name = $product -> product_name;
            $detail -> quantity = $productData['quantity'];
            $detail->height = $height;
            $detail->width = $width;
            $detail->color = $productData['color'];
            $detail -> price = $productData['price'];
            $detail -> save();
        }
        return response()->json([
            'result' => true,
            'message' => 'Created successfully.',
        ]);
    }

    public function customerByEmail($keyword = null){
        if($keyword != null) {
            $accounts = Account::where('email', 'LIKE', '%' . $keyword . '%')->where('role_id', 1)->get();
        } else {
            $accounts = Account::all();
        }
        if($accounts -> isEmpty())
            return response()->json([]);
        foreach($accounts as $account){
            $image = null;
            if ($account->image_id !== null) {
                $storagePath = public_path('images/account/');
                $filename = $account->image->image_url;
                $data = file_get_contents($storagePath. $filename);
                $base64Image = base64_encode($data);
                $image = [
                    'imageId' => $account->image->image_id,
                    'imageUrl' => $base64Image,
                ];
            }
            $accountData[] = [
                'accountId' => $account -> id,
                'fullName' => $account -> full_name,
                'email' => $account -> email,
                'phoneNumber' => $account -> phone_number,
                'image' => $image
            ];
        }
        return response()->json($accountData);

    }

    public function productByIdOrName($keyword = null){
        if($keyword != null) {
            $products = Product::where('product_id', 'LIKE', "%{$keyword}%")
            -> orWhere('product_name', 'LIKE', "%{$keyword}%")
            -> where('is_hide', true)
            -> get();
        } else {
            $products = Product::all();
        }
        if($products -> isEmpty())
            return response()->json([]);
        foreach($products as $product){
            $imageData = null;
            if ($product->images !== null) {
                foreach ($product->images as $image) {
                    if ($image->image_id !== null) {
                        $storagePath = public_path('images/product/');
                        $filename = $image -> image_url;
                        $data = file_get_contents($storagePath. $filename);
                        $base64Image = base64_encode($data);
                        $imageData[] = [
                            'imageId' => $image->image_id,
                            'imageUrl' => $base64Image,
                        ];
                    }
                }
            }
            $productData[] = [
                'productId' => $product -> product_id,
                'productName' => $product -> product_name,
                'images' => $imageData
            ];
        }
        return response()->json($productData);
    }

    public function findAllPayment(){
        $payments = PaymentMethod::all();
        foreach($payments as $payment){
            $paymentData[] = [
                'paymentMethodId' => $payment -> payment_method_id,
                'paymentMethodName' => $payment -> payment_method_name,
            ];
        }
        return response()->json($paymentData);
    }

    public function findAllStatus(){
        $statuses = OrderStatus::all();
        foreach($statuses as $status){
            $statusData[] = [
                'orderStatusId' =>  $status -> order_status_id,
                'statusName' => $status -> status_name,
                'statusDescription' => $status -> status_description,
            ];
        }
        return response()->json($statusData);
    }

    public function isEmailExists($email) {
        $exists = Account::where('email', $email)->exists();
        return ($exists);
    }

    public function findOrderStatusByOrderId($id) {
        $order = Order::find($id);
        $orderStatus = $order -> status -> first();

        $orderStatusData = [
            'orderStatusId' => $orderStatus -> order_status_id,
            'statusName' => $orderStatus -> status_name
        ];

        return response()->json($orderStatusData);
    }
}
