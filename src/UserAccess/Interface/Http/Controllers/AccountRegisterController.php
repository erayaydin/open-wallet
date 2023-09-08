<?php

namespace OpenWallet\UserAccess\Interface\Http\Controllers;

use Illuminate\Http\JsonResponse;
use OpenWallet\Shared\Interface\Http\Controllers\Controller;
use OpenWallet\UserAccess\Application\Register\AccountRegisterCommand;
use OpenWallet\UserAccess\Interface\Http\Requests\AccountRegisterRequest;

final class AccountRegisterController extends Controller
{
    public function __invoke(AccountRegisterRequest $request): JsonResponse
    {
        $id = $this->generateUuid();

        $this->dispatchCommand(
            new AccountRegisterCommand(
                $id,
                $request->get('name'),
                $request->get('email'),
                $request->get('password')
            )
        );

        return response()->json(['user' => ['id' => $id]], 201);
    }
}
