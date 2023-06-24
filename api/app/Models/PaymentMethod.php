<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $table = 'payment_method';
    protected $primaryKey = 'payment_method_id';
    protected $fillable = ['payment_method_name'];

    public static function store( $payment_method_name)
    {
        return DB::table('payment_method')->insert(['payment_method_name' => $payment_method_name]);
    }
    
    public static function destroy($id){
        return DB::table('payment_method')->where('payment_method_id', '=', $id)->delete();
    }

    public static function edit($id, $payment_method_name){
        return DB::table('payment_method')->where('payment_method_id', $id)->update(['payment_method_name' => $payment_method_name]);
    }

  
}
