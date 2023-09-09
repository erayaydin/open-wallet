<?php

namespace OpenWallet\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use OpenWallet\Api\Http\Requests\AccountCreateRequest;
use OpenWallet\Api\Http\Requests\AccountEditRequest;
use OpenWallet\Api\Http\Resources\AccountResource;
use OpenWallet\Models\Account;
use OpenWallet\Models\Currency;
use OpenWallet\Models\User;

class AccountController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = $request->user();

        return AccountResource::collection($user->accounts()->paginate(20));
    }

    public function store(AccountCreateRequest $request): AccountResource
    {
        /** @var User $user */
        $user = $request->user();
        /** @var Account $account */
        $account = $user->accounts()->make($request->validated());

        /** @var Currency $currency */
        $currency = $user->currencies()->where('currency', $request->input('currency'))->firstOrFail();
        $account->currency()->associate($currency);

        $account->save();

        return new AccountResource($account);
    }

    public function show(Account $account): AccountResource
    {
        return new AccountResource($account);
    }

    public function update(AccountEditRequest $request, Account $account): AccountResource
    {
        $account->update($request->validated());

        return new AccountResource($account);
    }

    public function destroy(Account $account): Response
    {
        $account->delete();

        return response()->noContent(status: 202);
    }
}
