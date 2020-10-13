<?php

namespace App\Application\Command\User\Profile\Edit;

use App\Application\Command\CommandHandlerInterface;
use App\Application\Event\EventBusInterface;
use App\Model\User\Entity\UserProfile;
use App\Model\User\Event\EditedUserProfileEvent;
use App\Model\User\Repository\UserProfileRepositoryInterface;

class EditUserProfileCommandHandler implements CommandHandlerInterface
{
    private UserProfileRepositoryInterface $userProfileRepository;
    private EventBusInterface $eventBus;

    public function __construct(UserProfileRepositoryInterface $userProfileRepository,
                                EventBusInterface $eventBus)
    {
        $this->userProfileRepository = $userProfileRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(EditUserProfileCommand $command): UserProfile
    {
        $userProfile = $this->userProfileRepository->getOneByUserId($command->getUserId());

        $userProfile->setFirstName($command->getFirstName());
        $userProfile->setLastName($command->getLastName());
        $userProfile->setBirthday($command->getBirthday());
        $userProfile->setGender($command->getGender());
        $this->userProfileRepository->add($userProfile);

        $this->eventBus->handle(
            new EditedUserProfileEvent(
                $userProfile->getUser()->getEmail(),
                $userProfile->getFirstName(),
                $userProfile->getLastName(),
                $userProfile->getGender(),
                $userProfile->getBirthday()->format('Y-m-d H:i:s')
            )
        );

        return $userProfile;
    }


}