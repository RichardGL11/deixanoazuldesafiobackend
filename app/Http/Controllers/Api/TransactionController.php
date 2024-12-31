<?php

namespace App\Http\Controllers\Api;

use App\Actions\CreateTransactionAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransanctionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    public function __construct(
        public CreateTransactionAction $CreateTransactionAction,
    ){}

    public function index()
    {
        $transactions = Transaction::with('wallet.user')->paginate(5);

        return TransactionResource::collection($transactions);
    }

    /**
     * @throws \Throwable
     */
    public function store(CreateTransanctionRequest $request):void
    {
        $this->CreateTransactionAction->execute($request);
    }

    public function destroy(Transaction $transaction)
    {
        DB::transaction(function () use ( $transaction) {
            $transaction->delete();
            return response()->json(['message' => 'Transaction Deleted Successfully'], 200);
        });

    }
}
