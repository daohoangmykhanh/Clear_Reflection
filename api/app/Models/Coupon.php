<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupon';
    protected $primaryKey = 'coupon_id';
    protected $fillable = ['coupon_name','discount','coupon_type_id','description','created_at','expired_at'];
    public $timestamps = true;

    public static function store($coupon_name,$discount,$coupon_type_id,$description,$expired_at)
    {
        return DB::table('coupon')->insert([
            'coupon_name' => $coupon_name,
            'discount' => $discount,
            'coupon_type_id' => $coupon_type_id,
            'description' => $description,
            'created_at' => now(),
            'expired_at' => $expired_at
        ]);
    }
    
    public static function destroy($id){
        return DB::table('coupon')->where('coupon_id', '=', $id)->delete();
    }

    public static function edit($id,$coupon_name,$discount,$coupon_type_id,$description,$expired_at){
        return DB::table('coupon')->where('coupon_id', $id)->update([
            'coupon_name' => $coupon_name,
            'discount' => $discount,
            'coupon_type_id' => $coupon_type_id,
            'description' => $description,
            'expired_at' => $expired_at
        ]);
    }
}
