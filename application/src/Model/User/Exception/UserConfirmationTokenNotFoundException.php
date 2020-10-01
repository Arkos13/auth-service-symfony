<?php

namespace App\Model\User\Exception;

use DomainException;
use Exception;

class UserConfirmationTokenNotFoundException extends DomainException
{
    public function __construct(Exception $previous = null)
    {
        parent::__construct("Confirmation token not found", 442, $previous);
    }
}
