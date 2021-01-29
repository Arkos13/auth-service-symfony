<?php

namespace App\Application\Command\User\RegistrationViaNetwork;

use App\Application\Command\CommandHandlerInterface;
use App\Model\Shared\Entity\Id;
use App\Model\Shared\Event\EventBusInterface;
use App\Model\User\Entity\User;
use App\Model\User\Exception\NetworkAlreadyExistsException;
use App\Model\User\Repository\NetworkRepositoryInterface;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Application\Service\PasswordHasher\PasswordHasherInterface;

class RegistrationViaNetworkCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userRepository;
    private PasswordHasherInterface $passwordHasher;
    private NetworkRepositoryInterface $networkRepository;
    private EventBusInterface $eventBus;

    public function __construct(UserRepositoryInterface $userRepository,
                                PasswordHasherInterface $passwordHasher,
                                NetworkRepositoryInterface $networkRepository,
                                EventBusInterface $eventBus)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->networkRepository = $networkRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(RegistrationViaNetworkCommand $command): void
    {
        if ($this->checkExists($command->email, $command->network)) {
            throw new NetworkAlreadyExistsException();
        }

        if ($user = $this->getUserExists($command->email)) {
            $user->addNetwork(
                $command->identifier,
                $command->network,
                $command->networkAccessToken
            );
            return;
        }

        $randPassword = strval(rand(100000, 999999));

        $user = User::createByNetwork(
            Id::create(),
            $command->email,
            $this->passwordHasher->hash(strval($randPassword)),
            $command->firstName,
            $command->lastName,
            $command->identifier,
            $command->network,
            $command->networkAccessToken
        );
        $this->userRepository->add($user);

        $this->eventBus->handle(...$user->pullDomainEvents());
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