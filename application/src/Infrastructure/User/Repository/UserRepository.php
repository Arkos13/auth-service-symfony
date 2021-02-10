<?php

namespace App\Infrastructure\User\Repository;

use App\Model\User\Entity\User;
use App\Model\User\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class UserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->em
            ->getRepository(User::class)
            ->findOneBy(["email" => $email]);
    }

    public function findOneByConfirmationToken(string $token): ?User
    {
        return $this->em
            ->getRepository(User::class)
            ->findOneBy(["confirmationToken" => $token]);
    }

    public function findOneById(string $id): ?User
    {
        return $this->em->getRepository(User::class)->find($id);
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
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

    /**
     * @param string $email
     * @return User
     * @throws EntityNotFoundException
     */
    public function getOneByEmail(string $email): User
    {
        if (!($user = $this->findOneByEmail($email))) {
            throw new EntityNotFoundException("User not found");
        }

        return $user;
    }

    public function checkExistsPhone(string $phone): bool
    {
        $phone = $this
            ->em
            ->createQueryBuilder()
            ->from(User::class, "u")
            ->select("p.phone")
            ->innerJoin("u.profile", "p")
            ->where("p.phone = :phone")
            ->setParameter("phone", $phone)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return !!$phone;
    }
}
