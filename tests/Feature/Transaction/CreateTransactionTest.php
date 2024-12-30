<?php

use App\Enums\TransactionTypeEnum;
use App\Models\Transaction;
use App\Models\Wallet;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\getJson;
use function Pest\Laravel\withoutExceptionHandling;

it('create a transaction', function () {

    withoutExceptionHandling();
    $user = \App\Models\User::factory()->create();
    $wallet = Wallet::factory()->create([
        'user_id' => $user->id,
    ]);
    Sanctum::actingAs($user);
    $request = getJson(route('transaction.store',[
        'wallet_id' => $wallet->id,
        'type' => TransactionTypeEnum::CREDITO->value
    ]));
    $request->assertStatus(200);

    assertDatabaseCount(Transaction::class, 1);
    assertDatabaseHas(Transaction::class, [
        'wallet_id' => $wallet->id,
        'type' => TransactionTypeEnum::CREDITO->value
    ]);

    expect($user->wallet->id)->toBe($wallet->id);
});
