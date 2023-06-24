<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = 'account';
    protected $primaryKey = 'account_id';
    protected $fillable = ['username','password','full_name','email','phone_number', 'image_id', 'address', 'role_id', 'created_at', 'updated_at'];
    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }
}
