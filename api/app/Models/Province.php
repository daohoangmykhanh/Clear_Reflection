<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'provinces';
    protected $primaryKey = 'code';
    public $timestamps = false;

    // Định nghĩa các cột trong bảng "provinces"
    protected $fillable = [
        'code',
        'name',
        'name_en',
        'full_name',
        'full_name_en',
        'code_name',
        'administrative_unit_id',
    ];
    protected $casts = [
        'code' => 'string',
    ];
    // Định nghĩa quan hệ với bảng District
    public function districts()
    {
        return $this->hasMany(District::class, 'province_code', 'code');
    }
}
