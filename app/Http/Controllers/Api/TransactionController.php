<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransanctionRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function store(CreateTransanctionRequest $request)
    {
        DB::transaction(function () use ($request) {
            Transaction::query()->create([
                'wallet_id' => $request->validated('wallet_id'),
                'type'      => $request->validated('type')
            ]);
            return response()->json(['message' => 'Transaction Created Successfully'], 200);
        });

    }
}
