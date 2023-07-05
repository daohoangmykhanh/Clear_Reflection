<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $primaryKey = 'order_id';
    protected $fillable = ['order_tracking_number','account_id','coupon_id','total_price','total_quantity','order_status_id','payment_method_id','created_at','updated_at' ];


}  

    
