<?php

namespace App\Infrastructure\User\Repository;

use App\Model\User\Entity\Network;
use App\Model\User\Repository\NetworkRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

class NetworkRepository implements NetworkRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $email
     * @param string $network
     * @return Network|null
     * @throws NonUniqueResultException
     */
    public function findOneByEmailAndNetwork(string $email, string $network): ?Network
    {
        return $this->em->createQueryBuilder()
            ->select("networks")
            ->from(Network::class, "networks")
            ->innerJoin("networks.user", "user")
            ->andWhere("user.email = :email")->setParameter("email", $email)
            ->andWhere("networks.network = :network")->setParameter("network", $network)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $email
     * @param string $accessToken
     * @param string $network
     * @return Network|null
     * @throws NonUniqueResultException
     */
    public function findOneByEmailAndAccessToken(string $email, string $accessToken, string $network): ?Network
    {
        return $this->em->createQueryBuilder()
            ->select("networks")
            ->from(Network::class, "networks")
            ->innerJoin("networks.user", "user")
            ->andWhere("user.email = :email")->setParameter("email", $email)
            ->andWhere("networks.accessToken = :accessToken")->setParameter("accessToken", $accessToken)
            ->andWhere("networks.network = :network")->setParameter("network", $network)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function updateAccessToken(Network $network, ?string $accessToken): void
    {
        $network->setAccessToken($accessToken);
        $this->em->persist($network);
        $this->em->flush();
    }
}
