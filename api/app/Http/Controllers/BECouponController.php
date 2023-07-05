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
            return response()->json('No results found!');
        }
        foreach($coupons as $coupon){
            
            $couponData[] = [
                'coupon_id' => $coupon->coupon_id,
                'code' => $coupon->code,
                'discount' => $coupon->discount,
                'description' => $coupon->description,
                'coupon_type_id' => $coupon->coupon_type_id,
                'created_at' => $coupon->created_at,
                'expired_at' => $coupon->expired_at,
            ];
        }
        return response()->json($couponData);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'code' => 'required|unique:coupon',
            'discount' => 'required',
            'description' => 'nullable',
            'coupon_type_id' => 'required',
            'created_at' => 'required',
            'expired_at' => 'required',
        ]);
        $coupon = new Coupon();
        $coupon -> code = $validatedData['code'];
        $coupon -> discount = $validatedData['discount'];
        $coupon -> coupon_type_id = $validatedData['coupon_type_id'];
        $coupon -> created_at = $validatedData['created_at'];
        $coupon -> expired_at = $validatedData['expired_at'];
        $result = $coupon -> save();
        if(!$result)
            return response()->json('Created unsuccessfully !');
        
        return response()->json('Created successfully !', 201);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'code' => 'required|unique:coupon,code,'. $id . ',coupon_id',
            'discount' => 'required',
            'description' => 'nullable',
            'coupon_type_id' => 'required',
            'created_at' => 'required',
            'expired_at' => 'required',
        ]);
        $coupon = Coupon::find($id);
        $coupon -> code = $validatedData['code'];
        $coupon -> discount = $validatedData['discount'];
        $coupon -> coupon_type_id = $validatedData['coupon_type_id'];
        $coupon -> created_at = $validatedData['created_at'];
        $coupon -> expired_at = $validatedData['expired_at'];
        $result = $coupon -> save();
        if(!$result)
            return response()->json('Updated unsuccessfully !');
    
        return response()->json([
            'message' => 'Updated successfully.',
            'coupon' => $coupon
        ]);
    }

    public function delete($id){
        if(Coupon::find($id) == null)
            return response()->json('Id doesn`t exist !');
        $accounts = AccountCoupon::where('coupon_id',$id) -> get();
        if($accounts -> isNotEmpty()){
            return response()->json('Coupon was used, cannot delete!');
        }
        $result = Coupon::destroy($id);
        if(!$result)
            return response()->json('Deleted unsuccessfully !');
    
        return response()->json('Deleted successfully !', 201);
    }
}