<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCoupon extends Model
{
    use HasFactory;
    protected $table = 'account_coupon';
    protected $primaryKey = 'coupon_id';
    protected $fillable = ['account_id','is_used'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }


}
