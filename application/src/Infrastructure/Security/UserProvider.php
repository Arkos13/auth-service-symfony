<?php

namespace App\Infrastructure\Security;

use App\Model\User\Entity\User;
use App\Model\User\Repository\UserRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loadUserByUsername(string $username)
    {
        return $this->loadUser($username);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException('Invalid user class ' . get_class($user));
        }
        return $this->loadUser($user->getUsername());
    }

    public function supportsClass(string $class): bool
    {
        return $class === User::class;
    }

    private function loadUser(string $username): User
    {
        $user = $this->userRepository->findOneByEmail(strtolower($username));
        if (empty($user)) {
            throw new UsernameNotFoundException();
        }
        if ($user->getConfirmationToken()) {
            throw new AccessDeniedHttpException("This user account is not confirmed");
        }
        return $user;
    }
}
