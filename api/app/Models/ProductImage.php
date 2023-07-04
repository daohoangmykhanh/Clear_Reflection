<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'product_image';
    protected $primaryKey = 'product_id';
    protected $fillable = ['product_id','image_id'];
    public $timestamps = false;
    public static function store($product_id, $image_id)
    {
        return DB::table('product_image')->insert([
            'product_id' => $product_id,
            'image_id' => $image_id
        ]);
    }
    
    public static function destroy($id){
        return DB::table('product_image')->where('product_id', '=', $id)->delete();
    }

    public static function edit($id, $product_id, $image_id){
        return DB::table('product_image')->where('product_id', $id)->update([
            'product_id' => $product_id,
            'image_id' => $image_id
        ]);
    }

    public function image(){
        return $this->belongsTo(Image::class,'image_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

}
