<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $table = 'order_address';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'address_id',
        'order_id',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
