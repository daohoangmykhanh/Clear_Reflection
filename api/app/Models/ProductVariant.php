<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variant';
    protected $primaryKey = 'product_variant_id';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'height',
        'width',
        'color_id',
        'quantity',
        'price',
        'image_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'color_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
