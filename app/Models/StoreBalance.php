<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class StoreBalance extends Model
{
    use UUID;

    protected $fillable = [
        'store_id',
        'balance'
    ];

    protected $cast = [
        'balance' => 'decimal:2'
    ];

    //store balance is owned by one store

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
