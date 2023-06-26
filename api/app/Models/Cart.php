<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $primaryKey = 'cart_id';
    protected $fillable = ['account_id','product_id','quantity'];

    public static function store($account_id,$product_id,$quantity)
    {
        return DB::table('cart')->insert([
            'account_id' => $account_id,
            'product_id' => $product_id,
            'quantity' => $quantity
        ]);
    }
    
    public static function destroy($id){
        return DB::table('cart')->where('role_id', '=', $id)->delete();
    }

    public static function edit($id,$quanity){
        return DB::table('cart')->where('cart_detail_id', $id)->update([
            'quantity' => $quanity,
        ]);
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
 
}
