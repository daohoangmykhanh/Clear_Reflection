<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    use HasFactory;
    protected $table = 'wards';
    protected $primaryKey = 'code';
    protected $fillable = ['name','name_en','full_name','full_name_en','code_name','district','administrative_unit_id'];

    public static function store($code,$name,$name_en,$full_name,$full_name_en,$code_name,$district,$administrative_unit_id)
    {
        return DB::table('wards')->insert([
            'code' => $code,
            'name' => $name,
            'name_en' => $name_en,
            'full_name' => $full_name,
            'full_name_en' => $full_name_en,
            'code_name' => $code_name,
            'district' => $district,
            'administrative_unit_id' => $administrative_unit_id,
        ]);
    }
    
    public static function destroy($id){
        return DB::table('wards')->where('code', '=', $id)->delete();
    }

    public static function edit($id,$name,$name_en,$full_name,$full_name_en,$code_name,$administrative_unit_id,$administrative_region_id){
        return DB::table('wards')->where('code', $id)->update([
            'name' => $name,
            'name_en' => $name_en,
            'full_name' => $full_name,
            'full_name_en' => $full_name_en,
            'code_name' => $code_name,
            'administrative_unit_id' => $administrative_unit_id,
            'administrative_region_id' => $administrative_region_id
        ]);
    }
    public function districts(){
        return $this->belongsTo(Districts::class,'code');
    }

    public function administrative_unit(){
        return $this->belongsTo(AdministrativeUnit::class,'id');
    }
 
}
