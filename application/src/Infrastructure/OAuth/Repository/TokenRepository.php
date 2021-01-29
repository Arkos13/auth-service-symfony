<?php

namespace App\Infrastructure\OAuth\Repository;

use App\Model\OAuth\Repository\TokenRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class TokenRepository implements TokenRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function revokeByAccessTokenId(string $id): void
    {
        $this->em->getConnection()
            ->createQueryBuilder()
            ->update("oauth2_access_token")
            ->set('revoked', "'t'")
            ->where("identifier = :accessTokenId")
            ->setParameter('accessTokenId', $id)
            ->execute();

        $this->em->getConnection()
            ->createQueryBuilder()
            ->update("oauth2_refresh_token")
            ->set('revoked', "'t'")
            ->where("access_token = :accessTokenId")
            ->setParameter('accessTokenId', $id)
            ->execute();
    }
}