<?php

use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\actingAs;
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

it('should list just one user by his id', function () {
    $user = \App\Models\User::factory()->create([
        'name'=> 'joedoe',
        'email'=> 'joe@gmail.com',
        'CPF'=> '371.303.198-36',
        'birthdate' => '2000-01-01',
        'created_at' => '2000-01-01 00:00:00',
    ]);
    $anotherUser = \App\Models\User::factory()->create();
    Sanctum::actingAs($user);

    $request = getJson(route('users.show', $anotherUser));

    $request->assertJsonStructure([

    ]);
    $request->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'email',
            'CPF',
            'birthdate',
            'created_at'
        ]
    ]);

        $request->assertJsonFragment([
            'id'         => $anotherUser->id,
            'name'       => $anotherUser->name,
            'email'      => $anotherUser->email,
            'CPF'        => $anotherUser->CPF,
            'birthdate'  => $anotherUser->birthdate,
            'created_at' => $anotherUser->created_at,
        ]);

        $request->assertJsonMissing([
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'CPF'        => $user->CPF,
            'birthdate'  => $user->birthdate,
            'created_at' => $user->created_at,
        ]);

});
