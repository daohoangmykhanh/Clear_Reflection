<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressAccount extends Model
{
    use HasFactory;

    protected $table = 'account_address';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'address_id',
        'account_id',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
