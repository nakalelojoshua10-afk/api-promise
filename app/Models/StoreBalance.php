<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // 💡 Fixed typo here: changed '$cast' to '$casts' (plural)
    protected $casts = [
        'balance' => 'decimal:2'
    ];

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