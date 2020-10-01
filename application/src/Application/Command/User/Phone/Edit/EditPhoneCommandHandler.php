<?php

namespace App\Application\Command\User\Phone\Edit;

use App\Model\User\Event\EditedUserPhoneEvent;
use App\Model\User\Repository\UserProfileRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class EditPhoneCommandHandler implements MessageHandlerInterface
{
    private UserProfileRepositoryInterface $userProfileRepository;
    private MessageBusInterface $eventBus;

    public function __construct(UserProfileRepositoryInterface $userProfileRepository, MessageBusInterface $eventBus)
    {
        $this->userProfileRepository = $userProfileRepository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param EditPhoneCommand $command
     * @throws EntityNotFoundException
     */
    public function __invoke(EditPhoneCommand $command): void
    {
        if (!($profile = $this->userProfileRepository->findOneByUserId($command->getProfileId()))) {
            throw new EntityNotFoundException("Profile not found");
        }

        $profile->setPhone($command->getPhone());
        $this->userProfileRepository->add($profile);

        $this->eventBus->dispatch(new EditedUserPhoneEvent($profile->getUser()->getEmail(), $command->getPhone()));

    }
}