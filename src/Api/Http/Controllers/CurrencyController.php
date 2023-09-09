<?php

namespace OpenWallet\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use OpenWallet\Api\Http\Requests\CurrencyCreateRequest;
use OpenWallet\Api\Http\Requests\CurrencyEditRequest;
use OpenWallet\Api\Http\Resources\CurrencyResource;
use OpenWallet\Models\Currency;
use OpenWallet\Models\User;

class CurrencyController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = $request->user();

        return CurrencyResource::collection($user->currencies()->get());
    }

    public function store(CurrencyCreateRequest $request): CurrencyResource
    {
        /** @var User $user */
        $user = $request->user();
        /** @var Currency $category */
        $currency = $user->currencies()->create($request->validated());

        return new CurrencyResource($currency);
    }

    public function show(Currency $currency): CurrencyResource
    {
        return new CurrencyResource($currency);
    }

    public function update(CurrencyEditRequest $request, Currency $currency): CurrencyResource
    {
        $currency->update($request->validated());

        return new CurrencyResource($currency);
    }

    public function destroy(Currency $currency): Response
    {
        $currency->delete();

        return response()->noContent(status: 202);
    }
}
