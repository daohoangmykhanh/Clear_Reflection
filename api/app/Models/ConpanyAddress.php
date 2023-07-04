<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAddress extends Model
{
    use HasFactory;

    protected $table = 'company_address';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'address_id',
        'company_information_id',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id');
    }

    public function companyInformation()
    {
        return $this->belongsTo(CompanyInformation::class, 'company_information_id', 'company_information_id');
    }
}
