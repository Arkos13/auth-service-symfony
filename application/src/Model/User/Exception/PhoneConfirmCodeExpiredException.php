<?php

namespace App\Model\User\Exception;

use DomainException;
use Exception;

class PhoneConfirmCodeExpiredException extends DomainException
{
    public function __construct(Exception $previous = null)
    {
        parent::__construct("Code expired", 450, $previous);
    }
}
