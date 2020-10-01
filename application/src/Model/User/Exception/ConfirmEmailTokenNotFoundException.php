<?php

namespace App\Model\User\Exception;

use DomainException;
use Exception;

class ConfirmEmailTokenNotFoundException extends DomainException
{
    public function __construct(Exception $previous = null)
    {
        parent::__construct("Confirm email token not found", 444, $previous);
    }
}
