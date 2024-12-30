<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::query()->orderBy('created_at','desc')->get());
    }

    public function show(User $user): UserResource
    {
        return UserResource::make($user);
    }
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


    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
