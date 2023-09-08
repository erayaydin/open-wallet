<?php

namespace OpenWallet\UserAccess\Domain\Aggregate;

use DateTimeImmutable;
use OpenWallet\Shared\Domain\Aggregate\AggregateRoot;
use OpenWallet\UserAccess\Domain\ValueObject\UserEmail;
use OpenWallet\UserAccess\Domain\ValueObject\UserEmailVerifiedAt;
use OpenWallet\UserAccess\Domain\ValueObject\UserId;
use OpenWallet\UserAccess\Domain\ValueObject\UserName;
use OpenWallet\UserAccess\Domain\ValueObject\UserPassword;

final class User extends AggregateRoot
{
    public function __construct(
        public readonly UserId $id,
        public readonly UserName $name,
        public readonly UserEmail $email,
        public readonly UserPassword $password,
        public readonly ?UserEmailVerifiedAt $emailVerifiedAt = null
    ) {
    }

    public static function from(
        string $id,
        string $name,
        string $email,
        string $password,
        DateTimeImmutable $emailVerifiedAt = null
    ): self {
        return new self(
            UserId::from($id),
            UserName::from($name),
            UserEmail::from($email),
            UserPassword::from($password),
            $emailVerifiedAt ? UserEmailVerifiedAt::from($emailVerifiedAt) : null
        );
    }

    public static function create(
        UserId $id,
        UserName $name,
        UserEmail $email,
        UserPassword $password,
        UserEmailVerifiedAt $emailVerifiedAt = null
    ): self {
        return new self($id, $name, $email, $password, $emailVerifiedAt);
    }
}
