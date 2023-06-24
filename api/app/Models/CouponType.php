<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponType extends Model
{
    use HasFactory;
    protected $table = 'coupon_type';
    protected $primaryKey = 'coupon_type_id';
    protected $fillable = ['coupon_type_name'];

    public static function store( $coupon_type_name)
    {
        return DB::table('coupon_type')->insert(['coupon_type_name' => $coupon_type_name]);
    }
    
    public static function destroy($id){
        return DB::table('coupon_type')->where('coupon_type_id', '=', $id)->delete();
    }

    public static function edit($id, $coupon_type_name){
        return DB::table('coupon_type')->where('coupon_type_id', $id)->update(['coupon_type_name' => $coupon_type_name]);
    }

  
}
