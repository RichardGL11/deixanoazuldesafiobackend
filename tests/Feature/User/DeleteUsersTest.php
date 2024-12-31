<?php

use App\Enums\TransactionTypeEnum;
use App\Models\Transaction;
use App\Models\Wallet;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

it('should delete an user', function () {
    $user= \App\Models\User::factory()->create();
    Sanctum::actingAs($user);
    $request =  deleteJson(route('users.destroy',$user));

    $request->assertStatus(200);
    $request->assertJson(['message' => 'User deleted successfully']);

    assertDatabaseCount(\App\Models\User::class,0);
    assertDatabaseMissing(\App\Models\User::class,[
        'id' => $user->id,
    ]);
});

it('should not delete an user if he has an transaction', function () {
    $user= \App\Models\User::factory()->create();
    $wallet = Wallet::factory()->create([
        'user_id' => $user->id,
    ]);
    Transaction::factory()->create([
        'wallet_id' => $wallet->id,
        'type' => TransactionTypeEnum::CREDITO->value,
    ]);
    Sanctum::actingAs($user);
    $request =  deleteJson(route('users.destroy',$user));

    $request->assertStatus(403);
    $request->assertJson(['message' => 'User cannot be deleted because it has transactions']);

    assertDatabaseCount(\App\Models\User::class,1);
    assertDatabaseHas(\App\Models\User::class,[
        'id' => $user->id,
    ]);
});
