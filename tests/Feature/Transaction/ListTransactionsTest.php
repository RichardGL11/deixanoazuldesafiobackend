<?php

use App\Enums\TransactionTypeEnum;
use App\Models\Transaction;
use App\Models\Wallet;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\getJson;

it('should list all transactions paginated', function (){
    $users = \App\Models\User::factory()->count(10)->create();
    $LoggedUser = \App\Models\User::factory()->create();
    $wallet = Wallet::factory()->create([
        'user_id' => $LoggedUser->id,
    ]);
    $transaction = Transaction::factory()->create([
        'wallet_id' => $wallet->id,
        'type'      => TransactionTypeEnum::DEBITO->value,
        'amount'    => 100
    ]);
    Sanctum::actingAs($LoggedUser);

    $request = getJson(route('transactions.index'));

    $request->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'wallet_id',
                'type',
                'user'=> [
                    'id',
                    'name',
                    'email',
                    'CPF',
                    'birthdate',
                    'created_at'
                ],
            ]
        ]
    ]);

    $request->assertJsonFragment([
            'id'        => $transaction->id,
            'wallet_id' => $wallet->id,
            'type'      => $transaction->type,
            'amount'    => $transaction->amount,
            'user'      => [
                            'id'         => $LoggedUser->id,
                            'name'       => $LoggedUser->name,
                            'email'      => $LoggedUser->email,
                            'CPF'        => $LoggedUser->CPF,
                            'birthdate'  => $LoggedUser->birthdate,
                            'created_at' => $LoggedUser->created_at,
            ]
        ]);
});


