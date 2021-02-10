<?php

namespace App\Infrastructure\User\ReadModel;

use App\ReadModel\User\UserAuthDTO;
use App\ReadModel\User\UserFetcherInterface;
use Doctrine\DBAL\Driver\Result;
use Doctrine\ORM\EntityManagerInterface;

class UserFetcher implements UserFetcherInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findForAuthByEmail(string $email): ?UserAuthDTO
    {
        /** @var Result $result */
        $result = $this->em
            ->getConnection()
            ->createQueryBuilder()
            ->select("u.id, u.email, u.password, u.confirmation_token")
            ->from("users", "u")
            ->where("u.email = :email")
            ->setParameter("email", $email)
            ->execute();

        $data = $result->fetchAssociative();

        return $data ? UserAuthDTO::fromArray($data) : null;
    }
}