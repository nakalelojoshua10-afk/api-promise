<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StoreBalance extends Model
{
    use UUID, HasFactory;

    /**
     * Tell Eloquent that the primary key is a string (UUID)
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Tell Eloquent NOT to auto-increment the ID
     * 
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = [
        'store_id',
        'balance'
    ];

    protected $casts = [
        'balance' => 'decimal:2'
    ];

    /**
     * Intercept the lifecycle event sequence cleanly.
     */
    protected static function booted(): void
    {
        // 💡 FIXED: Changed 'created' to 'saved' to ensure parent model row exists first
        static::saved(function (StoreBalance $storeBalance) {
            
            // Only generate the initial ledger history log if it doesn't already exist
            if ($storeBalance->storeBalanceHistories()->count() === 0) {
                $storeBalance->storeBalanceHistories()->create([
                    'id' => (string) Str::uuid(),
                    'type' => 'initial',
                    'amount' => $storeBalance->balance,
                    'remarks' => 'Pembuatan Store Baru',
                ]);
            }
        });
    }

    public function scopeSearch($query, $search) {
        return $query->whereHas('store', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });
    }

    // store balance is owned by one store
    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function storeBalanceHistories() {
        return $this->hasMany(StoreBalanceHistory::class);
    }

    public function withdrawals(){
        return $this->hasMany(Withdrawal::class);
    }
}