<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = 'account';
    protected $primaryKey = 'account_id';
    protected $fillable = ['username','password','full_name','email','phone_number', 'image_id', 'role_id', 'created_at', 'updated_at'];
    public $timestamps = true;

    public static function store($validatedData){
        $username = $validatedData['username'];
        $password = $validatedData['password'];
        $full_name = $validatedData['full_name'];
        $email = $validatedData['email'];
        $phone_number = $validatedData['phone_number'];
        $role_id = $validatedData['role_id'];
        $image_id = $validatedData['image_id'];
     
        return DB::table('account')->insert([
            'username' => $username,
            'password' => $password,
            'full_name' => $full_name,
            'email' => $email,
            'phone_number' => $phone_number, 
            'role_id' => $role_id, 
            'image_id' => $image_id, 
            'created_at' => now()
        ]);
    }

    public static function edit($validatedData){
        $id = $validatedData['account_id'];
        $password = $validatedData['password'];
        $full_name = $validatedData['full_name'];
        $email = $validatedData['email'];
        $phone_number = $validatedData['phone_number'];
        $image_id = $validatedData['image_id'];
     
        return DB::table('account')->where('account_id', $id)->update([
            'password' => $password,
            'full_name' => $full_name,
            'email' => $email,
            'phone_number' => $phone_number, 
            'image_id' => $image_id, 
            'updated_at' => now()
        ]);
    }
    public static function destroy($id){
        return DB::table('account')->where('account_id', '=', $id)->delete();
    }

    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }

    
}
