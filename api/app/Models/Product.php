<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $fillable = ['product_name','description','is_hide','category_id','product_shape_id','product_style_id','created_at','updated_at'];
    public $timestamps = true;
    public static function store($product_name,$description,$is_hide,$category_id,$product_shape_id,$product_style_id)
    {
        return DB::table('product')->insert([
            'product_name' => $product_name,
            'description' => $description,
            'is_hide' => $is_hide,
            'category_id' => $category_id,
            'product_shape_id' => $product_shape_id,
            'product_style_id' => $product_style_id,
            'created_at' => now(),
        ]);
    }
    
    public static function destroy($id){
        return DB::table('product')->where('product_id', '=', $id)->delete();
    }

    public static function edit($id,$product_name,$description,$is_hide,$category_id,$product_shape_id,$product_style_id){
        return DB::table('product')->where('product_id', $id)->update([
            'product_name' => $product_name,
            'description' => $description,
            'is_hide' => $is_hide,
            'category_id' => $category_id,
            'product_shape_id' => $product_shape_id,
            'product_style_id' => $product_style_id,
        ]);
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function product_shape(){
        return $this->belongsTo(ProductShape::class,'product_shape_id');
    }

    public function product_style(){
        return $this->belongsTo(Category::class,'product_style_id');
    }
}

