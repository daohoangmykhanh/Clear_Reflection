<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $primaryKey = 'category_id';
    protected $fillable = ['category_name',	'image_id'];
    public $timestamps = true;
    public static function store($category_name, $image_id)
    {
        
        return DB::table('category')->insert([
            'category_name' => $category_name,
            'image_id' => $image_id,
            'created_at' => now()
        ]);
    }
    
    public static function destroy($id){
        return DB::table('category')->where('category_id', '=', $id)->delete();
    }

    public static function edit($id,$category_name, $image_id){
        return DB::table('category')->where('category_id', $id)->update([
            'category_name' => $category_name,
            'image_id' => $image_id,
            'updated_at' => now()
        ]);
    }
}
