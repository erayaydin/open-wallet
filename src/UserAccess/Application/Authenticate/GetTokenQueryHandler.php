<?php

namespace OpenWallet\UserAccess\Application\Authenticate;

use Illuminate\Contracts\Hashing\Hasher;
use OpenWallet\Shared\Domain\Bus\Query\QueryHandler;
use OpenWallet\UserAccess\Application\TokenResponse;
use OpenWallet\UserAccess\Domain\Exceptions\CredentialsWrongException;
use OpenWallet\UserAccess\Domain\Repository\UserRepository;
use OpenWallet\UserAccess\Domain\ValueObject\DeviceName;
use OpenWallet\UserAccess\Domain\ValueObject\UserEmail;

final readonly class GetTokenQueryHandler implements QueryHandler
{
    public function __construct(protected UserRepository $repository, protected Hasher $hasher)
    {
    }

    /**
     * @throws CredentialsWrongException
     */
    public function __invoke(GetTokenQuery $query): TokenResponse
    {
        $user = $this->repository->findByEmail(UserEmail::from($query->getEmail()));

        if (! $user || ! $this->hasher->check($query->getPassword(), $user->password->getValue())) {
            throw CredentialsWrongException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return new TokenResponse($this->repository->createToken($user->id, DeviceName::from($query->getDeviceName())));
    }
}
