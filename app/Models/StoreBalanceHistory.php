<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreBalanceHistory extends Model
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
        'store_balance_id',
        'type',
        'reference_id',
        'reference_type',
        'amount',
        'remarks'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function storeBalance(){
        return $this->belongsTo(StoreBalance::class);
    }
}