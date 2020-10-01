<?php

namespace App\Application\Service\User\Network\OAuth\Fetch;

use App\Model\User\Entity\Network;

interface FetchUserInterface
{
    /**
     * @param mixed $data
     * @return Network|null
     */
    public function fetch($data): ?Network;
}
