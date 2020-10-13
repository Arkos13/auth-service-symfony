<?php

namespace App\Infrastructure\Repository\User;

use App\Model\User\Entity\User;
use App\Model\User\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->findOneBy(["email" => $email]);
    }

    public function findOneByConfirmationToken(string $token): ?User
    {
        return $this->findOneBy(["confirmationToken" => $token]);
    }

    public function findOneById(string $id): ?User
    {
        return $this->find($id);
    }

    /**
     * @param User $user
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $id
     * @return User
     * @throws EntityNotFoundException
     */
    public function getOneById(string $id): User
    {
        if (!($user = $this->findOneById($id))) {
            throw new EntityNotFoundException("User not found");
        }

        return $user;
    }
}
