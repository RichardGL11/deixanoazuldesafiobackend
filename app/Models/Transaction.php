<?php

namespace App\Models;

use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;
    protected $fillable = ['type', 'wallet_id'];

    protected $casts = ['type' => TransactionTypeEnum::class];
    public function wallet():BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
