<?php

namespace OpenWallet\UserAccess\Application\Register;

use OpenWallet\Shared\Domain\Bus\Command\CommandHandler;
use OpenWallet\Shared\Domain\Bus\Event\EventBus;
use OpenWallet\UserAccess\Domain\Aggregate\User;
use OpenWallet\UserAccess\Domain\Exceptions\UserAlreadyExistsException;
use OpenWallet\UserAccess\Domain\Repository\UserRepository;
use OpenWallet\UserAccess\Domain\ValueObject\UserEmail;

final readonly class AccountRegisterCommandHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $repository,
        private EventBus $bus
    ) {
    }

    /**
     * @throws UserAlreadyExistsException
     */
    public function __invoke(AccountRegisterCommand $command): void
    {
        $email = UserEmail::from($command->email);
        $user = $this->repository->findByEmail($email);

        if ($user !== null) {
            throw new UserAlreadyExistsException();
        }

        $user = User::from(
            $command->id,
            $command->name,
            $command->email,
            $command->password
        );

        $this->repository->save($user);
        $this->bus->publish(...$user->pullDomainEvents());
    }
}
