<?php

namespace OpenWallet\Api\Http\Controllers\Auth;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use OpenWallet\Api\Http\Requests\AuthenticateRequest;
use OpenWallet\Models\User;

class AuthenticateController extends Controller
{
    public function __construct(private readonly Hasher $hasher)
    {
    }

    /**
     * @throws ValidationException
     */
    public function __invoke(AuthenticateRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()->where('email', $request->input('email'))->first();

        if (! $user || ! $this->hasher->check($request->input('password'), $user->getAttribute('password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken($request->input('device_name'))->plainTextToken,
        ]);
    }
}
