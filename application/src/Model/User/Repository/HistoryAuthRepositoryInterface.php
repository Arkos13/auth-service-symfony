<?php

namespace App\Model\User\Repository;

use App\Model\User\Entity\Security\HistoryAuth;

interface HistoryAuthRepositoryInterface
{
    public function add(HistoryAuth $historyAuth): void;
}
