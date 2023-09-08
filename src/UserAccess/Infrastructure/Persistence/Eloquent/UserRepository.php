<?php

namespace OpenWallet\UserAccess\Infrastructure\Persistence\Eloquent;

use Exception;
use Illuminate\Support\Facades\DB;
use OpenWallet\Shared\Infrastructure\Persistence\Eloquent\Exceptions\EloquentException;
use OpenWallet\UserAccess\Domain\Aggregate\User;
use OpenWallet\UserAccess\Domain\Repository\UserRepository as UserRepositoryInterface;
use OpenWallet\UserAccess\Domain\ValueObject\UserEmail;
use OpenWallet\UserAccess\Domain\ValueObject\UserId;
use OpenWallet\UserAccess\Infrastructure\Persistence\Eloquent\User as UserModel;

final class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly UserModel $model
    ) {
    }

    public function find(UserId $id): ?User
    {
        $user = $this->model->find($id->getValue());

        if ($user === null) {
            return null;
        }

        return $this->toDomain($user);
    }

    public function findByEmail(UserEmail $email): ?User
    {
        $user = $this->model->where('email', $email->getValue())->first();

        if ($user === null) {
            return null;
        }

        return $this->toDomain($user);
    }

    /**
     * @throws EloquentException
     */
    public function save(User $user): void
    {
        $model = $this->model->find($user->id->getValue());

        if ($model === null) {
            $model = new UserModel;
            $model->setAttribute('id', $user->id->getValue());
        }

        $model->setAttribute('name', $user->name->getValue());
        $model->setAttribute('email', $user->email->getValue());
        $model->setAttribute('password', $user->password->getValue());
        $model->setAttribute('email_verified_at', $user->emailVerifiedAt?->getValue());

        DB::beginTransaction();
        try {
            $model->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new EloquentException(
                $e->getMessage(),
                $e->getCode(),
                $e->getPrevious()
            );
        }
    }

    private function toDomain(UserModel $model): User
    {
        return User::from(
            $model->getAttribute('id'),
            $model->getAttribute('name'),
            $model->getAttribute('email'),
            $model->getAttribute('password'),
            $model->getAttribute('email_verified_at')
        );
    }
}
