<?php

namespace App\Actions;

use App\Http\Requests\CreateTransanctionRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class CreateTransactionAction
{
    public function __construct(public UpdateUserAmountAction $action)
    {}

    public function execute(CreateTransanctionRequest $request)
    {
        DB::beginTransaction();
        try {
           $transaction = Transaction::query()->create([
                'wallet_id' => $request->validated('wallet_id'),
                'amount'    => (float)$request->validated('amount'),
                'type'      => $request->validated('type'),
            ]);


            $user = Wallet::query()->findOrFail($request->validated('wallet_id'));
            $this->action->execute($user->user, $transaction);
            return response()->json(['message' => 'Transaction Created Successfully'], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

    }
}
