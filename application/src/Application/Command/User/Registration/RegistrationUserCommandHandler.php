<?php

namespace App\Application\Command\User\Registration;

use App\Application\Command\CommandHandlerInterface;
use App\Model\Shared\Entity\Id;
use App\Model\User\Entity\User;
use App\Model\User\Exception\EmailExistsException;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Application\Service\PasswordHasher\PasswordHasherInterface;

class RegistrationUserCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userRepository;
    private PasswordHasherInterface $passwordHasher;

    public function __construct(UserRepositoryInterface $userRepository,
                                PasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function __invoke(RegistrationUserCommand $command): void
    {
        if ($this->checkExistsEmail($command->email)) {
            throw new EmailExistsException("This email already exists.");
        }

        $user = User::create(
            Id::create(),
            $command->email,
            $this->passwordHasher->hash($command->password),
            $command->firstName,
            $command->lastName
        );
        $this->userRepository->add($user);
    }

    private function checkExistsEmail(string $email): bool
    {
        return !!$this->userRepository->findOneByEmail($email);
    }
}