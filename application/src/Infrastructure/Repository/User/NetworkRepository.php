<?php

namespace App\Infrastructure\Repository\User;

use App\Model\User\Entity\Network;
use App\Model\User\Repository\NetworkRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Network|null find($id, $lockMode = null, $lockVersion = null)
 * @method Network|null findOneBy(array $criteria, array $orderBy = null)
 * @method Network[]    findAll()
 * @method Network[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NetworkRepository extends ServiceEntityRepository implements NetworkRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Network::class);
    }

    /**
     * @param string $email
     * @param string $network
     * @return Network|null
     * @throws NonUniqueResultException
     */
    public function findOneByEmailAndNetwork(string $email, string $network): ?Network
    {
        return $this->createQueryBuilder("networks")
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
        return $this->createQueryBuilder("networks")
            ->innerJoin("networks.user", "user")
            ->andWhere("user.email = :email")->setParameter("email", $email)
            ->andWhere("networks.accessToken = :accessToken")->setParameter("accessToken", $accessToken)
            ->andWhere("networks.network = :network")->setParameter("network", $network)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param Network $network
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Network $network): void
    {
        $this->getEntityManager()->persist($network);
        $this->getEntityManager()->flush();
    }
}
