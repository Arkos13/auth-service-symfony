<?php

namespace App\Infrastructure\Repository\User;

use App\Model\User\Entity\UserProfile;
use App\Model\User\Repository\UserProfileRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProfile[]    findAll()
 * @method UserProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProfileRepository extends ServiceEntityRepository implements UserProfileRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserProfile::class);
    }

    public function findOneByUserId(string $userId): ?UserProfile
    {
        return $this->findOneBy(["user" => $userId]);
    }

    public function findOneByPhone(string $phone): ?UserProfile
    {
        return $this->findOneBy(["phone" => $phone]);
    }

    /**
     * @param UserProfile $userProfile
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(UserProfile $userProfile): void
    {
        $this->getEntityManager()->persist($userProfile);
        $this->getEntityManager()->flush();
    }
}
