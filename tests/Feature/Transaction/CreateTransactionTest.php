<?php

use App\Enums\TransactionTypeEnum;
use App\Exceptions\InssuficientBalanceException;
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
        'type'      => TransactionTypeEnum::CREDITO->value,
        'amount'    => 100
    ]));
    $request->assertStatus(200);

    assertDatabaseCount(Transaction::class, 1);
    assertDatabaseHas(Transaction::class, [
        'wallet_id' => $wallet->id,
        'type'      => TransactionTypeEnum::CREDITO->value,
        'amount'    => 100,
    ]);

    expect($user->wallet->id)->toBe($wallet->id);
});

it('should not create an trasaction if the user dont have balance enough', function () {
    $user = \App\Models\User::factory()->create([
        'balance' => 1
    ]);
    $wallet = Wallet::factory()->create([
        'user_id' => $user->id,
    ]);
    Sanctum::actingAs($user);
    $request = getJson(route('transaction.store',[
        'wallet_id' => $wallet->id,
        'type'      => TransactionTypeEnum::DEBITO->value,
        'amount'    => 100
    ]));
    $request->assertJsonFragment([
        'error' => 'User dont have money enough to do this transaction'
    ]);

    expect($request->exception)->toBeInstanceOf(InssuficientBalanceException::class);
});

describe('validation tests', function (){

    beforeEach(function () {
        $this->user = \App\Models\User::factory()->create();
        Sanctum::actingAs($this->user);
        $this->wallet =  Wallet::factory()->create([
            'user_id' => $this->user->id,
        ]);
    });

    test('wallet_id', function ($rule, $value){
        $request = getJson(route('transaction.store',[
            'wallet_id' => $value,
            'type'      => TransactionTypeEnum::CREDITO->value
        ]));
        $request->assertJsonValidationErrors(['wallet_id' => $rule]);

    })->with([
        'required' => ['required',''],
        'exists'   => ['The selected wallet id is invalid.', 999],
    ]);

    test('type',function ($rule, $value){
        $request = getJson(route('transaction.store',[
            'wallet_id' => $this->wallet->id,
            'type'      => $value
        ]));
        $request->assertJsonValidationErrors(['type' => $rule]);

    })->with([
        'required' => ['required',''],
        'enum'     => ['The selected type is invalid.', 'wrong type'],
    ]);

});
