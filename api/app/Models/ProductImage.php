<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_image';
    protected $primaryKey = ['product_id', 'image_id'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'image_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
