<?php

use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\getJson;

it('should list all users', function () {
    $LoggedUser= \App\Models\User::factory()->create();
    $users = \App\Models\User::factory(20)->create();

    sanctum::actingAs($LoggedUser);

   $request = getJson(route('users.index'));

   $request->assertJsonStructure([
      'data' => [
          '*' => [
              'id',
              'name',
              'email',
              'CPF',
              'birthdate',
              'created_at'
          ]
      ]
   ]);
    $users->each(function ($user) use($request) {
        $request->assertJsonFragment([
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'CPF'        => $user->CPF,
            'birthdate'  => $user->birthdate,
            'created_at' => $user->created_at,
        ]);

    });
});
