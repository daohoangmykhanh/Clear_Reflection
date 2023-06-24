<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStyle extends Model
{
    use HasFactory;
    protected $table = 'product_style';
    protected $primaryKey = 'product_style_id';
    protected $fillable = ['style_name'];

    public static function store( $style_name)
    {
        return DB::table('product_style')->insert(['style_name' => $style_name]);
    }
    
    public static function destroy($id){
        return DB::table('product_style')->where('product_style_id', '=', $id)->delete();
    }

    public static function edit($id, $style_name){
        return DB::table('product_style')->where('product_style_id', $id)->update(['style_name' => $style_name]);
    }

  
}
