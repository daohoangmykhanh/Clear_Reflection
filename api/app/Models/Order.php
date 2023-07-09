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
    protected $fillable = ['order_tracking_number', 'account_id','address_id', 'coupon_id', 'total_price', 'total_quantity', 'order_status_id', 'payment_method_id', 'created_at', 'updated_at'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function payment()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
}
