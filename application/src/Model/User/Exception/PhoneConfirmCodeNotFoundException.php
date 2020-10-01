<?php

namespace App\Model\User\Exception;

use DomainException;
use Exception;

class PhoneConfirmCodeNotFoundException extends DomainException
{
    public function __construct(Exception $previous = null)
    {
        parent::__construct("Code does not exists", 449, $previous);
    }
}
