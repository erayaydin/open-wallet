<?php

namespace OpenWallet\UserAccess\Interface\Http\Controllers;

use Illuminate\Http\JsonResponse;
use OpenWallet\Shared\Interface\Http\Controllers\Controller;
use OpenWallet\UserAccess\Application\Register\RegisterUserCommand;
use OpenWallet\UserAccess\Interface\Http\Requests\UserRegisterRequest;

final class UserRegisterController extends Controller
{
    public function __invoke(UserRegisterRequest $request): JsonResponse
    {
        $id = $this->generateUuid();

        $this->dispatchCommand(
            new RegisterUserCommand(
                $id,
                $request->get('name'),
                $request->get('email'),
                $request->get('password')
            )
        );

        return response()->json(['user' => ['id' => $id]], 201);
    }
}
