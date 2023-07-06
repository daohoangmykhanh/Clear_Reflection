<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponType extends Model
{
    use HasFactory;
    protected $table = 'coupon_type';
    protected $primaryKey = 'coupon_type_id';
    protected $fillable = ['coupon_type_name'];
    public $timestamps = false;

    

  
}
