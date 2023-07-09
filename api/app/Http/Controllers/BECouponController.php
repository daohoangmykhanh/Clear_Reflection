<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountCoupon;
use App\Models\Coupon;
use Illuminate\Http\Request;

class BECouponController extends Controller
{
    public function index(){
        $coupons = Coupon::all();
        if($coupons -> isEmpty()){
            return response()->json([
                'result' => false,
                'message' => "No results found!",
            ]);
        }
        foreach($coupons as $coupon){
            $couponData[] = [
                'couponId' => $coupon->coupon_id,
                'code' => $coupon->code,
                'discount' => $coupon->discount,
                'description' => $coupon->description,
                'couponTypeId' => $coupon->coupon_type_id,
                'createdAt' => $coupon->created_at,
                'expiredAt' => $coupon->expired_at,
            ];
        }
        return response()->json($couponData);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'code' => 'required|unique:coupon,code',
            'discount' => 'required',
            'description' => 'nullable',
            'couponTypeId' => 'required',
            'createdAt' => 'required',
            'expiredAt' => 'required',
        ]);
        $coupon = new Coupon();
        $coupon -> code = $validatedData['code'];
        $coupon -> discount = $validatedData['discount'];
        $coupon -> description = $validatedData['description'];
        $coupon -> coupon_type_id = $validatedData['couponTypeId'];
        $coupon -> created_at = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $validatedData['createdAt'])));
        $coupon -> expired_at = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $validatedData['expiredAt'])));
        $result = $coupon -> save();
        if(!$result)
            return response()->json('Created unsuccessfully !');

        return response()->json('Created successfully !', 201);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'code' => 'required|unique:coupon,code,'. $id . ',coupon_id',
            'discount' => 'required',
            'description' => 'required',
            'couponTypeId' => 'required',
            'createdAt' => 'required',
            'expiredAt' => 'required',
        ]);

        $coupon = Coupon::find($id);
        $coupon->code = $validatedData['code'];
        $coupon->discount = $validatedData['discount'];
        $coupon->description = $validatedData['description'];
        $coupon->coupon_type_id = $validatedData['couponTypeId'];
        $coupon->created_at = date('Y-m-d H:i:s', strtotime($request->input('createdAt')));
        $coupon->expired_at = date('Y-m-d H:i:s', strtotime($request->input('expiredAt')));
        $result = $coupon->save();

        if(!$result)
            return response()->json([
                'result' => false,
                'message' => 'Updated unsuccessfully.',
            ]);

        return response()->json([
            'result' => true,
            'message' => 'Updated successfully.',
        ]);
    }

    public function delete($id){
        if(Coupon::find($id) == null)
            return response()->json('Id doesn`t exist !');
        $accounts = AccountCoupon::where('coupon_id',$id) -> get();
        if($accounts -> isNotEmpty()){
            return response()->json([
                'result' => false,
                'message' => 'Coupon was used, cannot delete!',
            ]);

        }
        $result = Coupon::destroy($id);
        if(!$result)
            return response()->json([
                'result' => false,
                'message' => 'Deleted unsuccessfully.',
            ]);

        return response()->json([
            'result' => true,
            'message' => 'Deleted unsuccessfully.',
        ]);
    }
}
