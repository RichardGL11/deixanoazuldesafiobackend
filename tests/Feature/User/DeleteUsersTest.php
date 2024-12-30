<?php

use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\assertDatabaseCount;
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
