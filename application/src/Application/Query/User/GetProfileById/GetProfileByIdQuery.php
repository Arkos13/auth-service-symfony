<?php

namespace App\Application\Query\User\GetProfileById;

use App\Application\Query\QueryInterface;

/**
 * @psalm-immutable
*/
class GetProfileByIdQuery implements QueryInterface
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }


}