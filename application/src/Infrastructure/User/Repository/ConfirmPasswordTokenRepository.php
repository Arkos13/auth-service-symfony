<?php

namespace App\Infrastructure\User\Repository;

use App\Model\User\Entity\ConfirmPasswordToken;
use App\Model\User\Entity\User;
use App\Model\User\Repository\ConfirmPasswordTokenRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ConfirmPasswordTokenRepository implements ConfirmPasswordTokenRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findOneByUser(User $user): ?ConfirmPasswordToken
    {
        $tokens = $this->em
            ->getRepository(ConfirmPasswordToken::class)
            ->findBy(["user" => $user], ["expires" => "desc"], 1);

        if ($tokens) {
            return $tokens[0];
        }

        return null;
    }

    public function findOneByToken(string $token): ?ConfirmPasswordToken
    {
        return $this->em
            ->getRepository(ConfirmPasswordToken::class)
            ->findOneBy(["confirmationEmailToken" => $token]);
    }

    public function remove(ConfirmPasswordToken $token): void
    {
        $this->em->remove($token);
        $this->em->flush();
    }

    public function add(ConfirmPasswordToken $token): void
    {
        $this->em->persist($token);
        $this->em->flush();
    }
}
