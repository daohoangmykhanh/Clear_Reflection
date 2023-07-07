<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = 'image';
    protected $primaryKey = 'image_id';
    protected $fillable = ['image_url'];
    public $timestamps = false;
    public static function store($image_url) {
        return DB::table('image')->insertGetId(['image_url' => $image_url]);
    }

    public static function destroy($id){
        return DB::table('image')->where('image_id', '=', $id)->delete();
    }

    public static function edit($id, $image_url){
        return DB::table('image')->where('image_id', $id)->update(['image_url' => $image_url]);
    }
}
