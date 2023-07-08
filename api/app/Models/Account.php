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
    protected $fillable = ['password','full_name','email','phone_number', 'image_id', 'role_id', 'created_at', 'updated_at'];
    public $timestamps = true;


    public static function store($validatedData){
        $password = $validatedData['password'];
        $full_name = $validatedData['fullName'];
        $email = $validatedData['email'];
        $phone_number = $validatedData['phoneNumber'];
        $role_id = $validatedData['roleId'];

        $image = new Image();
        $base64String = $validatedData['image'];
        $base64Data = substr($base64String, strpos($base64String, ',') + 1);
        $imageData = base64_decode($base64Data);
        $filename = uniqid() . '.png';
        $storagePath = public_path('images/account/');
        file_put_contents($storagePath. $filename, $imageData);
        $image->image_url = $filename;
        $image->save();

        return DB::table('account')->insert([
            'password' => $password,
            'full_name' => $full_name,
            'email' => $email,
            'phone_number' => $phone_number,
            'role_id' => $role_id,
            'image_id' => $image -> image_id,
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

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

}
