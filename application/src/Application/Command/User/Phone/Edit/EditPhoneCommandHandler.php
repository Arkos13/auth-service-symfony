<?php

namespace App\Application\Command\User\Phone\Edit;

use App\Application\Command\CommandHandlerInterface;
use App\Model\Shared\Event\EventBusInterface;
use App\Model\User\Repository\UserRepositoryInterface;

class EditPhoneCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userRepository;
    private EventBusInterface $eventBus;

    public function __construct(UserRepositoryInterface $userRepository, EventBusInterface $eventBus)
    {
        $this->userRepository = $userRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(EditPhoneCommand $command): void
    {
        $user = $this->userRepository->getOneById($command->profileId);

        $user->setPhone($command->phone);
        $this->userRepository->add($user);

        $this->eventBus->handle(...$user->pullDomainEvents());

    }
}