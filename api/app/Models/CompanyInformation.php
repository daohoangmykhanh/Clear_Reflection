<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInformation extends Model
{
    use HasFactory;
    protected $table = 'company_information';
    protected $primaryKey = 'company_information_id';
    protected $fillable = ['company_name','company_address','company_phone_number',	'company_vat_number'];

    public static function store($company_name,$company_address,$company_phone_number,$company_vat_number)
    {
        return DB::table('company_information')->insert([
            'company_name' => $company_name,
            'company_address' => $company_address,
            'company_phone_number' => $company_phone_number,	
            'company_vat_number' => $company_vat_number
        ]);
    }
    
    public static function destroy($id){
        return DB::table('company_information')->where('company_information_id', '=', $id)->delete();
    }

    public static function edit($id, $company_name,$company_address,$company_phone_number,$company_vat_number){
        return DB::table('company_information')->where('company_information_id', $id)->update([
            'company_name' => $company_name,
            'company_address' => $company_address,
            'company_phone_number' => $company_phone_number,	
            'company_vat_number' => $company_vat_number
        ]);
    }
}
