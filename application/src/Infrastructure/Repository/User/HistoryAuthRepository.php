<?php

namespace App\Infrastructure\Repository\User;

use App\Model\User\Entity\Security\HistoryAuth;
use App\Model\User\Repository\HistoryAuthRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HistoryAuth|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryAuth|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryAuth[]    findAll()
 * @method HistoryAuth[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryAuthRepository extends ServiceEntityRepository implements HistoryAuthRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryAuth::class);
    }

    /**
     * @param HistoryAuth $historyAuth
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(HistoryAuth $historyAuth): void
    {
        $this->getEntityManager()->persist($historyAuth);
        $this->getEntityManager()->flush();
    }
}
