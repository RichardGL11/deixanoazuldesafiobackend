<?php

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;
use function Pest\Laravel\withoutExceptionHandling;

it('should be able to create an new user', function () {

    withoutExceptionHandling();
   $request =  postJson(route('user.store'),[
       'name'                  => 'joedoe',
       'email'                 => 'joedoe@gmail.com',
       'birthdate'             => '22-01-2000',
       'CPF'                   => '68586002054',
       'password'              => 'password',
       'password_confirmation' => 'password',
    ]);

    $request->assertStatus(201);

    assertDatabaseHas(\App\Models\User::class, [
        'name' => 'joedoe',
        'email' => 'joedoe@gmail.com',
        'birthdate' => '2000-01-22',
        'CPF'  => '68586002054',
    ]);

    assertDatabaseCount(\App\Models\User::class, 1);


});


describe('validation tests',function (){

    test('name',function ($rule,$value){
        $request =  postJson(route('user.store'),[
            'name'                  => $value,
            'email'                 => 'joedoe@gmail.com',
            'birthdate'             => '22-01-2000',
            'CPF'                   => '68586002054',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $request->assertJsonValidationErrors(['name' => $rule]);


    })->with([
        'required'  => ['required', ''],
        'min:3'     => ['The name field must be at least 3 characters.', 'aa'],
        'max'       => ['The name field must not be greater than 255 characters.', str_repeat('a',256)],
    ]);

    test('email',function ($rule,$value){
        $user = \App\Models\User::factory()->create(['email' => 'joedoe@gmail.com']);
        $request =  postJson(route('user.store'),[
            'name'                  =>'joedoe',
            'email'                 =>  $value,
            'birthdate'             => '22-01-2000',
            'CPF'                   => '68586002054',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $request->assertJsonValidationErrors(['email' => $rule]);


    })->with([
        'required'  => ['required', ''],
        'max'       => ['The email field must not be greater than 255 characters.', str_repeat('a',256)],
        'unique'       => ['The email has already been taken.', 'joedoe@gmail.com'],
    ]);

    test('birthdate',function ($rule,$value){
        $request =  postJson(route('user.store'),[
            'name'                  =>' joedoe',
            'email'                 => 'joedoe@gmail.com',
            'birthdate'             => $value,
            'CPF'                   => '68586002054',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $request->assertJsonValidationErrors(['birthdate' => $rule]);


    })->with([
        'required'   => ['required', ''],
        'format'     => ['The birthdate field must match the format d-m-Y.', '2000-22-01'],
        'before'     => ['It should have at least 21 years old.', '22-01-2015'],
    ]);


    test('CPF',function ($rule,$value){
        $request =  postJson(route('user.store'),[
            'name'                  =>' joedoe',
            'email'                 => 'joedoe@gmail.com',
            'birthdate'             => '22-01-2000',
            'CPF'                   => $value,
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $request->assertJsonValidationErrors(['CPF' => $rule]);


    })->with([
        'required'      => ['required', ''],
        'numeric'       => ['The c p f field must be a number.', 'aaa'],
        'size'          => ['O CPF informado é inválido precisa ter exatos 11 caracteres.', '123'],
        'same_numbers'  => ['O CPF informado é inválido seus números não podem ser todos iguais.','11111111111'],
        'valid_cpf'     => ['O CPF informado é inválido.', '12222222222']
    ]);
});
