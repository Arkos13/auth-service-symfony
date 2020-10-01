<?php

namespace App\Infrastructure\Repository\User;

use App\Model\User\Entity\ConfirmEmailToken;
use App\Model\User\Entity\User;
use App\Model\User\Repository\ConfirmEmailTokenRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConfirmEmailToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfirmEmailToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfirmEmailToken[]    findAll()
 * @method ConfirmEmailToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfirmEmailTokenRepository extends ServiceEntityRepository implements ConfirmEmailTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfirmEmailToken::class);
    }

    public function findOneByUserAndEmail(User $user, string $email): ?ConfirmEmailToken
    {
        return $this->findOneBy(["user" => $user, "email" => $email]);
    }

    public function findOneByToken(string $token): ?ConfirmEmailToken
    {
        return $this->findOneBy(["confirmationEmailToken" => $token]);
    }

    /**
     * @param ConfirmEmailToken $token
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(ConfirmEmailToken $token): void
    {
        $this->getEntityManager()->remove($token);
        $this->getEntityManager()->flush();
    }

    /**
     * @param ConfirmEmailToken $token
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ConfirmEmailToken $token): void
    {
        $this->getEntityManager()->persist($token);
        $this->getEntityManager()->flush();
    }
}
