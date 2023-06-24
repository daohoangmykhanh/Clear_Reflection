<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCoupon extends Model
{
    use HasFactory;
    protected $table = 'account_coupon';
    protected $primaryKey = 'coupon_id';
    protected $fillable = ['name'];

    public static function store($account_id)
    {
        return DB::table('account_coupon')->insert(['account_id' => $account_id]);
    }
    
    public static function destroy($id){
        return DB::table('account_coupon')->where('coupon_id', '=', $id)->delete();
    }

    public static function edit($id){
        return DB::table('account_coupon')->where('coupon_id', $id)->update(['is_used' => false]);
    }
}
