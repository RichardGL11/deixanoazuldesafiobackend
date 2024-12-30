<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('createUser',[UserController::class, 'store'])->name('user.store');
Route::post('login',[AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('users',[UserController::class, 'index'])->name('users.index');
});
