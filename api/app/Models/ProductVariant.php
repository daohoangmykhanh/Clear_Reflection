<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $table = 'product_variant';
    protected $primaryKey = 'product_variant_id';
    protected $fillable = [	'product_variant_id','product_id','height','width','color_id','quantity','price','image_id'];

    public static function store($product_id,$height,$width,$color_id,$quantity,$price,$image_id)
    {
        return DB::table('product_variant')->insert([
            'product_id' => $product_id,
            'height' => $height,
            'width' => $width,
            'color_id' => $color_id,
            'quantity' => $quantity, 
            'price' => $price,
            'image_id' => $image_id
        ]);
    }
    
    public static function destroy($id){
        return DB::table('product_variant')->where('product_variant_id', '=', $id)->delete();
    }

    public static function edit($id,$product_id,$height,$width,$color_id,$quantity,$price,$image_id){
        return DB::table('product_variant')->where('product_variant_id', $id)->update([
            'product_id' => $product_id,
            'height' => $height,
            'width' => $width,
            'color_id' => $color_id,
            'quantity' => $quantity, 
            'price' => $price,
            'image_id' => $image_id
        ]);
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function color(){
        return $this->belongsTo(Color::class,'color_id');
    }
    public function image(){
        return $this->belongsTo(Image::class,'image_id');
    }
}
