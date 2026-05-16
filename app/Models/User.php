<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, UUID;

    /**
     * 1. Tell Eloquent that the primary key is a string (UUID)
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * 2. Tell Eloquent NOT to try and auto-increment the ID
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Scope a query to search users by name or email.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('email', 'like', "%{$search}%");
    }

    /**
     * User can have one store relationship
     */
    public function store() 
    {
        return $this->hasOne(Store::class);
    }
    
    /**
     * User can have one buyer relationship
     */
    public function buyer() 
    {
        return $this->hasOne(Buyer::class);
    }
}