<?php

namespace App\Actions;

use App\Enums\TransactionTypeEnum;
use App\Exceptions\InssuficientBalanceException;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateUserAmountAction
{

    /**
     * @throws InssuficientBalanceException|\Throwable
     */
    public function execute(User $user, Transaction $transaction)
    {
        if ($transaction->type->value == TransactionTypeEnum::DEBITO->value
            and
            (float) $user->balance < (float) $transaction->amount
        ){
            return throw new InssuficientBalanceException();
        }

        DB::beginTransaction();
        try {
          $newAmount =  match ($transaction->type->value){
                TransactionTypeEnum::DEBITO->value  => $user->amount - (float) $transaction->amount,
                TransactionTypeEnum::CREDITO->value => $user->amount + (float) $transaction->amount,
                TransactionTypeEnum::ESTORNO->value => $user->amount + (float) $transaction->amount,
                default => throw new \Exception('Transaction type not supported')
            };

          $user->balance = $newAmount;

          $user->save();
          DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
