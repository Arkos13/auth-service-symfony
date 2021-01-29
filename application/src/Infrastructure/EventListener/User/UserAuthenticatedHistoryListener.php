<?php

namespace App\Infrastructure\EventListener\User;

use App\Model\User\Entity\Security\HistoryAuth;
use App\Model\User\Repository\HistoryAuthRepositoryInterface;
use App\Model\User\Repository\UserRepositoryInterface;
use Exception;
use GeoIp2\Database\Reader;
use Psr\Log\LoggerInterface;

class UserAuthenticatedHistoryListener
{
    private UserRepositoryInterface $userRepository;
    private HistoryAuthRepositoryInterface $historyAuthRepository;
    private Reader $geoDatabaseReader;
    private LoggerInterface $logger;

    public function __construct(UserRepositoryInterface $userRepository,
                                HistoryAuthRepositoryInterface $historyAuthRepository,
                                Reader $geoDatabaseReader,
                                LoggerInterface $logger)
    {
        $this->userRepository = $userRepository;
        $this->historyAuthRepository = $historyAuthRepository;
        $this->geoDatabaseReader = $geoDatabaseReader;
        $this->logger = $logger;
    }

    public function onUserAuthenticatedHistory(UserAuthenticatedHistoryEvent $event): void
    {
        $user = $this->userRepository->getOneByEmail($event->getEmail());

        try {
            $geo = $this->geoDatabaseReader->city($event->getIp());
            $historyAuth = HistoryAuth::create(
                $user,
                $geo->city->name,
                $geo->country->isoCode,
                $geo->country->name,
                $geo->mostSpecificSubdivision->name,
                $event->getIp(),
                $event->getGuid()
            );
        } catch (Exception $e) {
            $this->logger->error("Geo exception - {$e->getMessage()}");

            $historyAuth = HistoryAuth::create(
                $user,
                null,
                null,
                null,
                null,
                $event->getIp(),
                $event->getGuid()
            );
        }

        $this->historyAuthRepository->add($historyAuth);
    }
}
