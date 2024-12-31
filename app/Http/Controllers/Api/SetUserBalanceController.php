<?php

namespace App\Http\Controllers\Api;

use App\Actions\UpdateUserAmountAction;
use App\Enums\TransactionTypeEnum;
use App\Exceptions\InssuficientBalanceException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SetUserBalanceRequest;
use App\Http\Resources\UserResource;
use App\Models\Transaction;
use App\Models\User;

class SetUserBalanceController extends Controller
{
    public function __construct(public  UpdateUserAmountAction $action)
    {}

    /**
     * @throws InssuficientBalanceException
     */
    public function __invoke(SetUserBalanceRequest $request, User $user): UserResource
    {
        $transaction = Transaction::create([
            'wallet_id' => $request->validated('wallet_id'),
            'amount' => $request->validated('amount'),
            'type' => TransactionTypeEnum::CREDITO->value,
        ]);
        $this->action->execute($user, $transaction);
        return UserResource::make($user);
    }
}
