<?php

namespace App\Model\User\Exception;

use DomainException;
use Exception;

class EmailExistsException extends DomainException
{
    public function __construct(string $message, Exception $previous = null)
    {
        parent::__construct($message, 440, $previous);
    }
}
