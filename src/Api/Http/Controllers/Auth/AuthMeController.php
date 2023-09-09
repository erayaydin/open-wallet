<?php

namespace OpenWallet\Api\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use OpenWallet\Api\Http\Resources\UserResource;

class AuthMeController extends Controller
{
    public function __invoke(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}
