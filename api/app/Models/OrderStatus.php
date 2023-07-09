<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;
    protected $table = 'order_status';
    protected $primaryKey = 'order_status_id';
    protected $fillable = ['status_name','status_description'];

    public static function store( $status_name,$status_description)
    {
        return DB::table('order_status')->insert([
            'status_name' => $status_name,
            'status_description' => $status_description
        ]);
    }

    public static function destroy($id){
        return DB::table('order_status')->where('order_status_id', '=', $id)->delete();
    }

    public static function edit($id,$status_name,$status_description){
        return DB::table('order_status')->where('order_status_id', $id)->update([
            'status_name' => $status_name,
            'status_description' => $status_description
        ]);
    }


}
