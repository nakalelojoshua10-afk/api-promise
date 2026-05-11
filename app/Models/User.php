<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\UUID;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, UUID;

    // Ensure this is exactly like this
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    

    /**
     * Get the attributes that should be cast.
     *
     * @var list<string>
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

    public function scopeSearch($query, $search)
    {
    return $query->where('name', 'like', "%{$search}%")
                 ->orWhere('email', 'like', "%{$search}%");
    }

    //User can have one store relationship
    public function store() {
        return $this->hasOne(Store::class);
    }
    
    public function buyer() {
        return $this->hasOne(Buyer::class);
    }
}
