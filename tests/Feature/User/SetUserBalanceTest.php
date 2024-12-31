<?php

use App\Enums\TransactionTypeEnum;
use App\Models\Transaction;
use App\Models\Wallet;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;
use function Pest\Laravel\withoutExceptionHandling;

it('should be able to set the users balance', function () {
    withoutExceptionHandling();
    $user = \App\Models\User::factory()->createOne();
    $wallet =  Wallet::factory()->create(['user_id' => $user->id]);
    Sanctum::actingAs($user);
    $request =postJson(route('user.amount',$user),[
        'wallet_id' => $wallet->id,
        'amount' => 1000,
    ]);

    $request->assertStatus(200);

    assertDatabaseHas(Transaction::class, [
        'wallet_id' => $wallet->id,
        'amount' => 1000,
        'type' => TransactionTypeEnum::CREDITO->value,
    ]);
    assertDatabaseCount(Transaction::class,1);

    $user->refresh();
    expect($user->balance)->toBe(1000.0);

    $request->assertJsonFragment(
        [
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'CPF'        => $user->CPF,
            'birthdate'  => $user->birthdate,
            'created_at' => $user->created_at,
        ]
    );

});
