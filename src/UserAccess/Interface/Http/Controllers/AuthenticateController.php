<?php

namespace OpenWallet\UserAccess\Interface\Http\Controllers;

use Illuminate\Http\JsonResponse;
use OpenWallet\Shared\Interface\Http\Controllers\Controller;
use OpenWallet\UserAccess\Application\Authenticate\GetTokenQuery;
use OpenWallet\UserAccess\Interface\Http\Requests\AuthenticateRequest;

final class AuthenticateController extends Controller
{
    public function __invoke(AuthenticateRequest $request): JsonResponse
    {
        $token = $this->askQuery(
            new GetTokenQuery(
                $request->get('email'),
                $request->get('password'),
                $request->get('device_name')
            )
        );

        return response()->json($token);
    }
}
