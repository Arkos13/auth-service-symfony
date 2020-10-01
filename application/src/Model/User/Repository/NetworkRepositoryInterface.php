<?php

namespace App\Model\User\Repository;

use App\Model\User\Entity\Network;

interface NetworkRepositoryInterface
{
    public function findOneByEmailAndNetwork(string $email, string $network): ?Network;
    public function findOneByEmailAndAccessToken(string $email, string $accessToken, string $network): ?Network;
    public function add(Network $network): void;
}
