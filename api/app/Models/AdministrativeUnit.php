<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministrativeUnit extends Model
{
    use HasFactory;
    protected $table = 'administrative_units';
    protected $primaryKey = 'id';
    protected $fillable = ['full_name','full_name_en','short_name','short_name_en','code_name','code_name_en','account_id'];

    public static function store($full_name,$full_name_en,$short_name,$short_name_en,$code_name,$code_name_en)
    {
        return DB::table('administrative_units')->insert([
            'full_name' => $full_name,
            'full_name_en' => $full_name_en,
            'short_name' => $short_name,
            'short_name_en' => $short_name_en,
            'code_name' => $code_name,
            'code_name_en' => $code_name_en
        ]);
    }
    
    public static function destroy($id){
        return DB::table('administrative_units')->where('id', '=', $id)->delete();
    }

    public static function edit($id,$full_name,$full_name_en,$short_name,$short_name_en,$code_name,$code_name_en){
        return DB::table('administrative_units')->where('id', $id)->update([
            'full_name' => $full_name,
            'full_name_en' => $full_name_en,
            'short_name' => $short_name,
            'short_name_en' => $short_name_en,
            'code_name' => $code_name,
            'code_name_en' => $code_name_en
        ]);
    }

}
