<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupon';
    protected $primaryKey = 'coupon_id';
    protected $fillable = ['coupon_name','discount','coupon_type_id','description','created_at','expired_at'];
    public $timestamps = false;

    public function couponType()
    {
        return $this->belongsTo(CouponType::class, 'coupon_type_id');
    }
}
