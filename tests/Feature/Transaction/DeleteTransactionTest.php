<?php

use App\Enums\TransactionTypeEnum;
use App\Models\Transaction;
use App\Models\Wallet;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

it('should delete a Transaction', function () {
    $user = \App\Models\User::factory()->create();
    $wallet = Wallet::factory()->create([
        'user_id' => $user->id,
    ]);
   $transaction =   Transaction::factory()->create([
        'wallet_id' => $wallet->id,
        'type' => TransactionTypeEnum::DEBITO->value,
    ]);

    Sanctum::actingAs($user);

    $request = deleteJson(route('transactions.destroy', compact(['transaction'])));

    $request->assertOk();

    expect($wallet->transactions->first())->toBeNull();
    assertdatabaseCount(Transaction::class, 0);
    assertDatabaseMissing(Transaction::class, [
        'id' => $transaction->id,
        'wallet_id' => $wallet->id,
    ]);

});
