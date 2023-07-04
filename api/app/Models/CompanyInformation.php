<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInformation extends Model
{
    use HasFactory;

    protected $table = 'company_information';
    protected $primaryKey = 'company_information_id';
    public $timestamps = false;

    protected $fillable = [
        'company_name',
        'company_address',
        'company_phone_number',
        'company_vat_number',
    ];
}
