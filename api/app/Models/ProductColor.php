<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;
    protected $table = 'product_color';
    protected $primaryKey = 'product_color_id';
    protected $fillable = ['color_name'];
    public $timestamps = false;
    public static function store($color_name)
    {
        return DB::table('product_color')->insert(['color_name' => $color_name]);
    }
    
    public static function destroy($id){
        return DB::table('product_color')->where('product_color_id', '=', $id)->delete();
    }

    public static function edit($id, $color_name){
        return DB::table('product_color')->where('product_color_id', $id)->update(['color_name' => $color_name]);
    }
}
