<?php

namespace App\Infrastructure\User\Repository;

use App\Model\User\Entity\Security\HistoryAuth;
use App\Model\User\Repository\HistoryAuthRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class HistoryAuthRepository implements HistoryAuthRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(HistoryAuth $historyAuth): void
    {
        $this->em->persist($historyAuth);
        $this->em->flush();
    }
}
