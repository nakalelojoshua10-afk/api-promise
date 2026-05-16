<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use UUID, HasFactory;

    /**
     * Tell Eloquent that the primary key is a string (UUID)
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Tell Eloquent NOT to try and auto-increment the ID
     * 
     * @var bool
     */
    public $incrementing = false;

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

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('phone', 'like', "%{$search}%");
    }

    // relationship one store has one user
    public function user() {
        return $this->belongsTo(User::class);
    }  
    
    public function storeBalance() {
        return $this->hasOne(StoreBalance::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}