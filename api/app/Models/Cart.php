<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $primaryKey = 'cart_id';
    protected $fillable = ['account_id'];

    public static function store($account_id)
    {
        return DB::table('cart')->insert(['account_id' => $account_id]);
    }
    
    public static function destroy($id){
        return DB::table('cart')->where('role_id', '=', $id)->delete();
    }

 
}
