<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $table = 'product_review';
    protected $primaryKey = 'product_review_id';
    protected $fillable = [
        'account_id',
        'product_id',
        'content',
        'rating',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
