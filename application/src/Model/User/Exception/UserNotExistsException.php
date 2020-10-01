<?php

namespace App\Model\User\Exception;

use DomainException;
use Exception;

class UserNotExistsException extends DomainException
{
    public function __construct(Exception $previous = null)
    {
        parent::__construct("User does not exists", 447, $previous);
    }
}
