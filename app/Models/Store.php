<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use UUID;

    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'about',
        'phone',
        'address_id',
        'city',
        'address',
        'postal_code',
        'is_verified'

    ];

    //relationship one store has one user
    public function user () {
        return $this->belongsTo(User::class);
    }  
    
    public function storeBallance() {
        return $this->hasOne(StoreBallance::class);
    }
}
