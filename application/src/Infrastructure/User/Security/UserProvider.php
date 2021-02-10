<?php

namespace App\Infrastructure\User\Security;

use App\ReadModel\User\UserFetcherInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private UserFetcherInterface $userFetcher;

    public function __construct(UserFetcherInterface $userFetcher)
    {
        $this->userFetcher = $userFetcher;
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
        return $class === UserIdentity::class;
    }

    private function loadUser(string $username): UserIdentity
    {
        $user = $this->userFetcher->findForAuthByEmail(strtolower($username));
        if (empty($user)) {
            throw new UsernameNotFoundException();
        }
        if ($user->confirmationToken) {
            throw new AccessDeniedHttpException("This user account is not confirmed");
        }
        return UserIdentity::create($user->id, $user->email, $user->password, $user->confirmationToken);
    }
}
