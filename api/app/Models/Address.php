<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';
    protected $primaryKey = 'address_id';
    protected $fillable = [
        'address_id',
        'house_number',
        'road_name',
        'wards_code',
        'district_code',
        'province_code',
    ];

    
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'wards_code', 'code');
    }


    // Định nghĩa quan hệ với bảng District
    public function district()
    {
        return $this->belongsTo(District::class,"district_code" ,'code');
    }

    // Định nghĩa quan hệ với bảng Province
    public function province()
    {
        return $this->belongsTo(Province::class,"province_code", 'code');
    }
}
