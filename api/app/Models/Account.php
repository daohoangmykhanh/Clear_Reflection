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
}
