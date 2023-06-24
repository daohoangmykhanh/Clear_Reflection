<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;
    protected $table = 'cart_detail';
    protected $primaryKey = 'cart_detail_id';
    protected $fillable = ['product_id','quantity','price','cart_id'];

    public static function store($product_id,$quanity,$price,$cart_id)
    {
        return DB::table('cart_detail')->insert([
            'product_id' => $product_id,
            'quantity' => $quanity,
            'price' => $price,
            'cart_id' => $cart_id
        ]);
    }
    
    public static function destroy($id){
        return DB::table('cart_detail')->where('cart_detail_id', '=', $id)->delete();
    }

    public static function edit($id, $product_id,$quanity,$price,$cart_id){
        return DB::table('cart_detail')->where('cart_detail_id', $id)->update([
            'product_id' => $product_id,
            'quantity' => $quanity,
            'price' => $price,
            'cart_id' => $cart_id
        ]);
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function cart(){
        return $this->belongsTo(Cart::class,'cart_id');
    }
}
