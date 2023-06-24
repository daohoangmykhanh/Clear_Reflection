<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';
    protected $primaryKey = 'invoice_id';
    protected $fillable = ['payment_method_id','coupon_id','invoice_status_id','account_id','created_at'];

    public static function store($payment_method_id,$coupon_id,$invoice_status_id,$account_id)
    {
        return DB::table('invoice')->insert([
            'payment_method_id' => $payment_method_id,
            'coupon_id' => $coupon_id,
            'invoice_status_id' => $invoice_status_id,
            'account_id' => $account_id,
            'created_at' => now()
        ]);
    }
    
    public static function destroy($id){
        return DB::table('invoice')->where('invoice_id', '=', $id)->delete();
    }

    public static function edit($id, $payment_method_id,$coupon_id,$invoice_status_id,$account_id){
        return DB::table('invoice')->where('invoice_id', $id)->update([
            'payment_method_id' => $payment_method_id,
            'coupon_id' => $coupon_id,
            'invoice_status_id' => $invoice_status_id,
            'account_id' => $account_id,
        ]);
    }
}
