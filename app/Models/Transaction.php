<?php

namespace App\Models;

use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;
    protected $fillable = ['type', 'wallet_id','amount'];

    protected $casts = ['type' => TransactionTypeEnum::class];
    public function wallet():BelongsTo
    {
        return $this->belongsTo(Wallet::class,'wallet_id');
    }

    public function user():HasOneThrough
    {
         return $this->hasOneThrough(User::class, Wallet::class, 'id', 'id', 'wallet_id', 'user_id');
    }
}
