<?php

namespace App\Application\Service\User\Token;

use App\Model\User\Entity\User;

interface TokenGeneratorInterface
{
    public function generateConfirmationToken(User $user): string;
}
