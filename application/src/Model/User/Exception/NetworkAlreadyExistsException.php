<?php

namespace App\Model\User\Exception;

use DomainException;
use Exception;

class NetworkAlreadyExistsException extends DomainException
{
    public function __construct(Exception $previous = null)
    {
        parent::__construct("This network account already exists", 448, $previous);
    }
}
