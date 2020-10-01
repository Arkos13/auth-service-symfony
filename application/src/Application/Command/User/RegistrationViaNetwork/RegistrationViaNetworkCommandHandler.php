<?php

namespace App\Application\Command\User\RegistrationViaNetwork;

use App\Application\Event\User\RegisteredViaNetwork\RegisteredUserViaNetworkEvent;
use App\Model\User\Entity\Network;
use App\Model\User\Entity\User;
use App\Model\User\Entity\UserProfile;
use App\Model\User\Exception\NetworkAlreadyExistsException;
use App\Model\User\Repository\NetworkRepositoryInterface;
use App\Model\User\Repository\UserProfileRepositoryInterface;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Application\Service\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class RegistrationViaNetworkCommandHandler implements MessageHandlerInterface
{
    private UserRepositoryInterface $userRepository;
    private UserProfileRepositoryInterface $userProfileRepository;
    private PasswordHasherInterface $passwordHasher;
    private NetworkRepositoryInterface $networkRepository;
    private MessageBusInterface $eventBus;

    public function __construct(UserRepositoryInterface $userRepository,
                                UserProfileRepositoryInterface $userProfileRepository,
                                PasswordHasherInterface $passwordHasher,
                                NetworkRepositoryInterface $networkRepository,
                                MessageBusInterface $eventBus)
    {
        $this->userRepository = $userRepository;
        $this->userProfileRepository = $userProfileRepository;
        $this->passwordHasher = $passwordHasher;
        $this->networkRepository = $networkRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(RegistrationViaNetworkCommand $command)
    {
        if ($this->checkExists($command->getEmail(), $command->getNetwork())) {
            throw new NetworkAlreadyExistsException();
        }

        if ($user = $this->getUserExists($command->getEmail())) {
            $this->networkRepository->add(
                Network::create(
                    $user,
                    $command->getIdentifier(),
                    $command->getNetwork(),
                    $command->getNetworkAccessToken()
                )
            );
            return $user;
        }

        $randPassword = rand(100000, 999999);

        $user = User::create(
            $command->getEmail(),
            $this->passwordHasher->hash(strval($randPassword))
        );
        $this->userRepository->add($user);

        $this->userProfileRepository->add(
            UserProfile::create(
                $user,
                $command->getFirstName(),
                $command->getLastName()
            )
        );

        $this->networkRepository->add(
            Network::create(
                $user,
                $command->getIdentifier(),
                $command->getNetwork(),
                $command->getNetworkAccessToken()
            )
        );

        $this->eventBus->dispatch(
            new RegisteredUserViaNetworkEvent(
                $user->getEmail(),
                $randPassword
            )
        );

        return $user;
    }

    private function getUserExists(string $email): ?User
    {
        return $this->userRepository->findOneByEmail($email);
    }

    private function checkExists(string $email, string $network): bool
    {
        return !!$this->networkRepository->findOneByEmailAndNetwork($email, $network);
    }


}