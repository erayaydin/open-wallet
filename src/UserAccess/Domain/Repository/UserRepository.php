<?php

namespace OpenWallet\UserAccess\Domain\Repository;

use OpenWallet\UserAccess\Domain\Aggregate\User;
use OpenWallet\UserAccess\Domain\ValueObject\UserEmail;
use OpenWallet\UserAccess\Domain\ValueObject\UserId;

interface UserRepository
{
    public function find(UserId $id): ?User;

    public function findByEmail(UserEmail $email): ?User;

    public function save(User $user): void;
}
