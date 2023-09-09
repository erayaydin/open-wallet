<?php

namespace OpenWallet\Api\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use OpenWallet\Api\Http\Requests\AuthRegisterRequest;
use OpenWallet\Api\Http\Resources\UserResource;
use OpenWallet\Models\User;

class AuthRegisterController extends Controller
{
    public function __invoke(AuthRegisterRequest $request): UserResource
    {
        /** @var User $user */
        $user = User::query()->create($request->validated());

        return new UserResource($user);
    }
}
