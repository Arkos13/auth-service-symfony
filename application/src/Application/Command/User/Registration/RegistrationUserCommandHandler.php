<?php

namespace App\Application\Command\User\Registration;

use App\Application\Command\CommandHandlerInterface;
use App\Application\Event\EventBusInterface;
use App\Application\Event\User\Registered\RegisteredUserEvent;
use App\Model\User\Entity\User;
use App\Model\User\Entity\UserProfile;
use App\Model\User\Exception\EmailExistsException;
use App\Model\User\Repository\UserProfileRepositoryInterface;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Application\Service\PasswordHasher\PasswordHasherInterface;

class RegistrationUserCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userRepository;
    private UserProfileRepositoryInterface $userProfileRepository;
    private PasswordHasherInterface $passwordHasher;
    private EventBusInterface $eventBus;

    public function __construct(UserRepositoryInterface $userRepository,
                                UserProfileRepositoryInterface $userProfileRepository,
                                PasswordHasherInterface $passwordHasher,
                                EventBusInterface $eventBus)
    {
        $this->userRepository = $userRepository;
        $this->userProfileRepository = $userProfileRepository;
        $this->passwordHasher = $passwordHasher;
        $this->eventBus = $eventBus;
    }

    public function __invoke(RegistrationUserCommand $command): User
    {
        if ($this->checkExistsEmail($command->getEmail())) {
            throw new EmailExistsException("This email already exists.");
        }

        $user = User::create(
            $command->getEmail(),
            $this->passwordHasher->hash($command->getPassword())
        );
        $this->userRepository->add($user);

        $this->userProfileRepository->add(
            UserProfile::create(
                $user,
                $command->getFirstName(),
                $command->getLastName()
            )
        );

        $this->eventBus->handle(
            new RegisteredUserEvent(
                $user->getEmail(),
                $command->getUrl()
            )
        );

        return $user;
    }

    private function checkExistsEmail(string $email): bool
    {
        return !!$this->userRepository->findOneByEmail($email);
    }
}