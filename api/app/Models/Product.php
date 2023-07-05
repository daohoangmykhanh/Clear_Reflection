<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    public $timestamps = true;

    protected $fillable = [
        'product_name',
        'description',
        'is_hide',
        'category_id',
        'product_shape_id',
        'product_style_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Define relationships with other models

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function product_shape()
    {
        return $this->belongsTo(ProductShape::class, 'product_shape_id');
    }

    public function product_style()
    {
        return $this->belongsTo(ProductStyle::class, 'product_style_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'product_image', 'product_id', 'image_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }
}
