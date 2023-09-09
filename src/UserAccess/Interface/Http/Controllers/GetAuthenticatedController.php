<?php

namespace OpenWallet\UserAccess\Interface\Http\Controllers;

use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\JsonResponse;
use OpenWallet\UserAccess\Domain\Aggregate\User;
use OpenWallet\UserAccess\Infrastructure\Persistence\Eloquent\User as UserModel;

final readonly class GetAuthenticatedController
{
    public function __construct(private AuthFactory $authFactory)
    {
    }

    public function __invoke(): JsonResponse
    {
        /** @var UserModel $auth */
        $auth = $this->authFactory->guard('sanctum')->user();

        $user = User::from(
            $auth->getAttribute('id'),
            $auth->getAttribute('name'),
            $auth->getAttribute('email'),
            $auth->getAttribute('password'),
            $auth->getAttribute('email_verified_at')
        );

        return response()->json(['user' => [
            'id' => $user->id->getValue(),
            'name' => $user->name->getValue(),
            'email' => $user->email->getValue(),
            'email_verified_at' => $user->emailVerifiedAt?->getValue(),
        ]]);
    }
}
