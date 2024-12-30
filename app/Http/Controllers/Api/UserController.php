<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(CreateUserRequest $request): JsonResponse
    {
        User::query()->create([
            'name' => $request->validated('name'),
            'CPF' => $request->validated('CPF'),
            'email' => $request->validated('email'),
            'birthdate' => $request->validated('birthdate'),
            'password' => Hash::make($request->validated('password')) ,
        ]);

                
        return response()->json(['message' => 'User created successfully'], 201);

    }
}
