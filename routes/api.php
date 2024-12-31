<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SetUserBalanceController;
use App\Http\Controllers\Api\TransactionController;
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
    Route::get('user/{user}',[UserController::class, 'show'])->name('users.show');
    Route::delete('user/{user}',[UserController::class, 'destroy'])->name('users.destroy');


    Route::get('/createTransaction', [TransactionController::class,'store'])->name('transaction.store');
    Route::get('/transactions', [TransactionController::class,'index'])->name('transactions.index');
    Route::delete('/transactions/{transaction}', [TransactionController::class,'destroy'])->name('transactions.destroy');

    Route::post('/user/{user}/update/amount', SetUserBalanceController::class)->name('user.amount');
});
