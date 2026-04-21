<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use UUID;

    protected $fillable = [
        'store_balance_id',
        'amount',
        'bank_account_name',
        'Bank_account_number',
        'Bank_name',
        'status'
    ];

    public function storeBalance() {
        return $this->belongsTo(StoreBalance::class);
    }
}
