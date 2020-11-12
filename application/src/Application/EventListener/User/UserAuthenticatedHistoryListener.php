<?php

namespace App\Application\EventListener\User;

use App\Model\User\Entity\Security\HistoryAuth;
use App\Model\User\Event\UserAuthenticatedHistoryEvent;
use App\Model\User\Repository\HistoryAuthRepositoryInterface;
use Exception;
use GeoIp2\Database\Reader;
use Psr\Log\LoggerInterface;

class UserAuthenticatedHistoryListener
{
    private HistoryAuthRepositoryInterface $historyAuthRepository;
    private Reader $geoDatabaseReader;
    private LoggerInterface $logger;

    public function __construct(HistoryAuthRepositoryInterface $historyAuthRepository,
                                Reader $geoDatabaseReader,
                                LoggerInterface $logger)
    {
        $this->historyAuthRepository = $historyAuthRepository;
        $this->geoDatabaseReader = $geoDatabaseReader;
        $this->logger = $logger;
    }

    public function onUserAuthenticatedHistory(UserAuthenticatedHistoryEvent $event): void
    {
        try {
            $geo = $this->geoDatabaseReader->city($event->getIp());
            $historyAuth = HistoryAuth::create(
                $event->getUser(),
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
                $event->getUser(),
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
