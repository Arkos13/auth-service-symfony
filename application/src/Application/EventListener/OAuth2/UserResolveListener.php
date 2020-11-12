<?php

namespace App\Application\EventListener\OAuth2;

use App\Model\User\Entity\Network;
use App\Model\User\Entity\User;
use App\Model\User\Event\UserAuthenticatedHistoryEvent;
use App\Model\User\Repository\NetworkRepositoryInterface;
use App\Application\Service\PasswordHasher\PasswordHasherArgon2i;
use SodiumException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\UserResolveEvent;

final class UserResolveListener
{
    private UserProviderInterface $userProvider;
    private RequestStack $requestStack;
    private EventDispatcherInterface $eventDispatcher;
    private PasswordHasherArgon2i $passwordHasher;
    private NetworkRepositoryInterface $networkRepository;

    public function __construct(UserProviderInterface $userProvider,
                                RequestStack $requestStack,
                                EventDispatcherInterface $eventDispatcher,
                                PasswordHasherArgon2i $passwordHasher,
                                NetworkRepositoryInterface $networkRepository)
    {
        $this->userProvider = $userProvider;
        $this->requestStack = $requestStack;
        $this->eventDispatcher = $eventDispatcher;
        $this->passwordHasher = $passwordHasher;
        $this->networkRepository = $networkRepository;
    }

    /**
     * @param UserResolveEvent $event
     * @throws SodiumException
     */
    public function onUserResolve(UserResolveEvent $event): void
    {
        try {
            /** @var User $user */
            $user = $this->userProvider->loadUserByUsername($event->getUsername());
        } catch (UsernameNotFoundException $e) {
            throw new UnauthorizedHttpException($e->getMessageKey(), $e->getMessage());
        }

        $request = $this->requestStack->getCurrentRequest();

        if ($request && $this->checkRequestNetwork($request) && !($network = $this->validateNetwork(
                $event->getUsername(),
                $request->request->get("networkAccessToken") ?? "",
                $request->request->get("provider") ?? "")
            )
        ) {
            throw new UnauthorizedHttpException('Invalid network', 'Invalid network');
        }

        if (empty($network) && !$this->passwordHasher->validate($event->getPassword(), $user->getPassword())) {
            throw new UnauthorizedHttpException('Invalid password', 'Invalid password');
        }

        if ($request && $request->getClientIp()) {
            $this->eventDispatcher->dispatch(
                new UserAuthenticatedHistoryEvent($user, $request->getClientIp(), $request->get("guid")),
                UserAuthenticatedHistoryEvent::NAME
            );
        }

        $event->setUser($user);
    }

    private function validateNetwork(string $email, string $accessToken, string $network): ?Network
    {
        $network = $this->networkRepository->findOneByEmailAndAccessToken($email, $accessToken, $network);
        if ($network) {
            $network->setAccessToken(null);
            $this->networkRepository->add($network);
        }
        return $network;
    }

    private function checkRequestNetwork(Request $request): bool
    {
        return $request->request->get("networkAccessToken") && $request->request->get("provider");
    }
}
