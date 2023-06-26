<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    use HasFactory;
    protected $table = 'districts';
    protected $primaryKey = 'code';
    protected $fillable = ['name','name_en','full_name','full_name_en','code_name','province_code','administrative_unit_id '];

    public static function store($code,$name,$name_en,$full_name,$full_name_en,$code_name,$province_code,$administrative_unit_id)
    {
        return DB::table('districts')->insert([
            'code' => $code,
            'name' => $name,
            'name_en' => $name_en,
            'full_name' => $full_name,
            'full_name_en' => $full_name_en,
            'code_name' => $code_name,
            'province_code' => $province_code,
            'administrative_unit_id' => $administrative_unit_id
        ]);
    }
    
    public static function destroy($id){
        return DB::table('districts')->where('code', '=', $id)->delete();
    }

    public static function edit($id,$name,$name_en,$full_name,$full_name_en,$code_name,$province_code,$administrative_unit_id){
        return DB::table('districts')->where('code', $id)->update([
            'name' => $name,
            'name_en' => $name_en,
            'full_name' => $full_name,
            'full_name_en' => $full_name_en,
            'code_name' => $code_name,
            'province_code' => $province_code,
            'administrative_unit_id' => $administrative_unit_id
        ]);
    }
    public function provinces(){
        return $this->belongsTo(Provinces::class,'code');
    }

    public function administrative_unit(){
        return $this->belongsTo(AdministrativeUnit::class,'id');
    }
 
}
