<?php

namespace App\Model\User\Exception;

use DomainException;
use Exception;

class TokenExpiredException extends DomainException
{
    public function __construct(Exception $previous = null)
    {
        parent::__construct("Token expired", 446, $previous);
    }
}
