<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'wishlist';
    protected $primaryKey = 'wishlist_id';
    protected $fillable = ['created_at','updated_at'];

    public static function store($account_id,$product_id)
    {
        return DB::table('wishlist')->insert([
            'account_id' => $account_id,
            'product_id' => $product_id
        ]);
    }
    
    public static function destroy($id){
        return DB::table('wishlist')->where('wishlist_id', '=', $id)->delete();
    }

}
