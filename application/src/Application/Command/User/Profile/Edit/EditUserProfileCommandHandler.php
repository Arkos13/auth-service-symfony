<?php

namespace App\Application\Command\User\Profile\Edit;

use App\Model\User\Entity\UserProfile;
use App\Model\User\Event\EditedUserProfileEvent;
use App\Model\User\Repository\UserProfileRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class EditUserProfileCommandHandler implements MessageHandlerInterface
{
    private UserProfileRepositoryInterface $userProfileRepository;
    private MessageBusInterface $eventBus;

    public function __construct(UserProfileRepositoryInterface $userProfileRepository,
                                MessageBusInterface $eventBus)
    {
        $this->userProfileRepository = $userProfileRepository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param EditUserProfileCommand $command
     * @return UserProfile
     * @throws EntityNotFoundException
     */
    public function __invoke(EditUserProfileCommand $command): UserProfile
    {
        if (!($userProfile = $this->userProfileRepository->findOneByUserId($command->getUserId()))) {
            throw new EntityNotFoundException("User not found");
        }

        $userProfile->setFirstName($command->getFirstName());
        $userProfile->setLastName($command->getLastName());
        $userProfile->setBirthday($command->getBirthday());
        $userProfile->setGender($command->getGender());
        $this->userProfileRepository->add($userProfile);

        $this->eventBus->dispatch(
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