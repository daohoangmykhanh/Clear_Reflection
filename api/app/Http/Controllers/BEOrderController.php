<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderDetail;
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
        $ward = $address -> address -> ward -> full_name_en;
        $district = $address -> address -> district -> full_name_en;
        $province = $address -> address -> province -> full_name_en;
        $shippingAddress = $road .", " . $ward .", " .  $district .", " .  $province;
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

}