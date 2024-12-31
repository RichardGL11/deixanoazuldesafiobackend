<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InssuficientBalanceException extends Exception
{

    public function render(): JsonResponse
    {
        return response()->json(['error' => 'User dont have money enough to do this transaction'],403);
    }
}
