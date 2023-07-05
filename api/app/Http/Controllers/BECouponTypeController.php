<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponType;
use Illuminate\Http\Request;

class BECouponTypeController extends Controller
{
    public function index(){
        $coupons = CouponType::all();
        if($coupons -> isEmpty()){
            return response()->json('No results found!');
        }
        foreach($coupons as $coupon){
            
            $couponData[] = [
                'coupon_type_id' => $coupon->coupon_type_id,
                'coupon_type_name' => $coupon->coupon_type_name,
      
            ];
        }
        return response()->json($couponData);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'coupon_type_name' => 'required|unique:coupon_type',
        ]);
        $coupon = new CouponType();
        $coupon -> coupon_type_name = $validatedData['coupon_type_name'];
       
        $result = $coupon -> save();
        if(!$result)
            return response()->json('Created unsuccessfully !');
        
        return response()->json('Created successfully !', 201);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'coupon_type_name' => 'required|unique:coupon_type,coupon_type_name,'. $id . ',coupon_type_id',
        ]);
        $coupon = CouponType::find($id);
        $coupon -> coupon_type_name = $validatedData['coupon_type_name'];
        $result = $coupon -> save();
        if(!$result)
            return response()->json('Updated unsuccessfully !');
    
        return response()->json([
            'message' => 'Updated successfully.',
            'coupon' => $coupon
        ]);
    }

    public function delete($id){
        if(CouponType::find($id) == null)
            return response()->json('Id doesn`t exist !');
        $coupons = Coupon::where('coupon_type_id',$id) -> get();
        if($coupons -> isNotEmpty()){
            return response()->json('Coupon type was used, cannot delete!');
        }
        $result = Coupon::destroy($id);
        if(!$result)
            return response()->json('Deleted unsuccessfully !');
    
        return response()->json('Deleted successfully !', 201);
    }
}