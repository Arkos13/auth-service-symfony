<?php

namespace App\Model\User\Exception;

use DomainException;
use Exception;

class ConfirmPasswordTokenNotFoundException extends DomainException
{
    public function __construct(Exception $previous = null)
    {
        parent::__construct("Confirm password token not found", 444, $previous);
    }
}
