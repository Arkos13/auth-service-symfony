<?php

namespace App\Model\User\Service\Token;

use App\Model\User\Entity\User;

interface TokenGeneratorInterface
{
    public function generateConfirmationToken(User $user): string;
}
