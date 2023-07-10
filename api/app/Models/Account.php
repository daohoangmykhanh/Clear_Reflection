<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;
    use HasApiTokens;
    protected $table = 'account';
    protected $primaryKey = 'id';
    protected $fillable = ['password', 'full_name', 'email', 'phone_number', 'image_id', 'role_id'];
    public $timestamps = true;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public static function store($validatedData)
    {
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
        file_put_contents($storagePath . $filename, $imageData);
        $image->image_url = $filename;
        $image->save();

        return DB::table('account')->insert([
            'password' => $password,
            'full_name' => $full_name,
            'email' => $email,
            'phone_number' => $phone_number,
            'role_id' => $role_id,
            'image_id' => $image->image_id,
            'created_at' => now()
        ]);
    }
    public function cart()
    {
        return $this->hasOne(Cart::class, 'account_id');
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'account_id');
    }
}
