<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceStatus extends Model
{
    use HasFactory;
    protected $table = 'invoice_status';
    protected $primaryKey = 'invoice_status_id';
    protected $fillable = ['coupon_type_name','status_name','status_description'];

    public static function store( $status_name,$status_description)
    {
        return DB::table('invoice_status')->insert([
            'status_name' => $status_name,
            'status_description' => $status_description
        ]);
    }
    
    public static function destroy($id){
        return DB::table('invoice_status')->where('invoice_status_id', '=', $id)->delete();
    }

    public static function edit($id,$status_name,$status_description){
        return DB::table('invoice_status')->where('invoice_status_id', $id)->update([
            'status_name' => $status_name,
            'status_description' => $status_description
        ]);
    }

    
}
