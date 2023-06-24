<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductShape extends Model
{
    use HasFactory;
    protected $table = 'product_shape';
    protected $primaryKey = 'product_shape_id';
    protected $fillable = ['shape_name'];

    public static function store( $shape_name)
    {
        return DB::table('product_shape')->insert(['shape_name' => $shape_name]);
    }
    
    public static function destroy($id){
        return DB::table('product_shape')->where('product_shape_id', '=', $id)->delete();
    }

    public static function edit($id, $shape_name){
        return DB::table('product_shape')->where('product_shape_id', $id)->update(['shape_name' => $shape_name]);
    }

  
}
