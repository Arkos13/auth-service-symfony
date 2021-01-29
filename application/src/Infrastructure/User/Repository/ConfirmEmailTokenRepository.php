<?php

namespace App\Infrastructure\User\Repository;

use App\Model\User\Entity\ConfirmEmailToken;
use App\Model\User\Entity\User;
use App\Model\User\Repository\ConfirmEmailTokenRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ConfirmEmailTokenRepository implements ConfirmEmailTokenRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findOneByUserAndEmail(User $user, string $email): ?ConfirmEmailToken
    {
        return $this->em
            ->getRepository(ConfirmEmailToken::class)
            ->findOneBy(["user" => $user, "email" => $email]);
    }

    public function findOneByToken(string $token): ?ConfirmEmailToken
    {
        return $this->em
            ->getRepository(ConfirmEmailToken::class)
            ->findOneBy(["confirmationEmailToken" => $token]);
    }

    public function remove(ConfirmEmailToken $token): void
    {
        $this->em->remove($token);
        $this->em->flush();
    }

    public function add(ConfirmEmailToken $token): void
    {
        $this->em->persist($token);
        $this->em->flush();
    }
}
