<?php

namespace App\Application\Command\User\Phone\Edit;

use App\Application\Command\CommandHandlerInterface;
use App\Application\Event\EventBusInterface;
use App\Model\User\Event\EditedUserPhoneEvent;
use App\Model\User\Repository\UserProfileRepositoryInterface;

class EditPhoneCommandHandler implements CommandHandlerInterface
{
    private UserProfileRepositoryInterface $userProfileRepository;
    private EventBusInterface $eventBus;

    public function __construct(UserProfileRepositoryInterface $userProfileRepository, EventBusInterface $eventBus)
    {
        $this->userProfileRepository = $userProfileRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(EditPhoneCommand $command): void
    {
        $profile = $this->userProfileRepository->getOneByUserId($command->getProfileId());

        $profile->setPhone($command->getPhone());
        $this->userProfileRepository->add($profile);

        $this->eventBus->handle(new EditedUserPhoneEvent($profile->getUser()->getEmail(), $command->getPhone()));

    }
}