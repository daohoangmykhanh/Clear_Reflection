<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $table = 'product_color';
    protected $primaryKey = 'product_color_id';
    public $timestamps = false;

    protected $fillable = [
        'color_name',
    ];
}
