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
    protected $fillable = ['account_id','house_number','road_name','wards_code','district_code','province_code'];

    public static function store($account_id,$house_number,$road_name,$wards_code,$district_code,$province_code)
    {
        return DB::table('address')->insert([
            'account_id' => $account_id,
            'house_number' => $house_number,
            'road_name' => $road_name,
            'wards_code' => $wards_code,
            'district_code' => $district_code,
            'province_code' => $province_code
        ]);
    }
    
    public static function destroy($id){
        return DB::table('address')->where('address_id', '=', $id)->delete();
    }

    public static function edit($id,$account_id,$house_number,$road_name,$wards_code,$district_code,$province_code){
        return DB::table('address')->where('address_id', $id)->update([
            'account_id' => $account_id,
            'house_number' => $house_number,
            'road_name' => $road_name,
            'wards_code' => $wards_code,
            'district_code' => $district_code,
            'province_code' => $province_code
        ]);
    }
    public function provinces(){
        return $this->belongsTo(Provinces::class,'code');
    }
    
    public function ward(){
        return $this->belongsTo(Wards::class,'code');
    }

    public function account(){
        return $this->belongsTo(Account::class,'account_id');
    }

    public function districts(){
        return $this->belongsTo(Districts::class,'code');
    }
}
