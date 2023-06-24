<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'role';
    protected $primaryKey = 'role_id';
    protected $fillable = ['name'];

    public static function store($name)
    {
        return DB::table('role')->insert(['name' => $name]);
    }
    
    public static function destroy($id){
        return DB::table('role')->where('role_id', '=', $id)->delete();
    }

    public static function edit($id, $name){
        return DB::table('role')->where('role_id', $id)->update(['name' => $name]);
    }
}
