<?php

namespace OpenWallet\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use OpenWallet\Api\Http\Requests\TransactionCreateRequest;
use OpenWallet\Api\Http\Requests\TransactionEditRequest;
use OpenWallet\Api\Http\Resources\TransactionResource;
use OpenWallet\Models\Account;
use OpenWallet\Models\Transaction;
use OpenWallet\Models\User;

class TransactionController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = $request->user();

        return TransactionResource::collection(
            $user->transactions()->with('sourceAccount')->paginate(20)
        );
    }

    public function store(TransactionCreateRequest $request): TransactionResource
    {
        /** @var Account $account */
        $account = Account::query()->find($request->input('source_account'));

        /** @var Transaction $transaction */
        $transaction = $account->transactions()->create($request->validated());

        return new TransactionResource($transaction);
    }

    public function show(Transaction $transaction): TransactionResource
    {
        return new TransactionResource($transaction);
    }

    public function update(TransactionEditRequest $request, Transaction $transaction): TransactionResource
    {
        if ($request->has('source_account')) {
            /** @var User $user */
            $user = $request->user('sanctum');
            /** @var Account $account */
            $account = $user->accounts()->find($request->input('source_account'));

            $transaction->sourceAccount()->associate($account);
        }

        $transaction->update($request->validated());

        return new TransactionResource($transaction);
    }

    public function destroy(Transaction $transaction): Response
    {
        $transaction->delete();

        return response()->noContent(status: 202);
    }
}
