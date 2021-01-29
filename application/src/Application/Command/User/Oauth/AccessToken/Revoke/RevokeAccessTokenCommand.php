<?php

namespace App\Application\Command\User\Oauth\AccessToken\Revoke;

use App\Application\Command\CommandInterface;

/**
 * @psalm-immutable
*/
class RevokeAccessTokenCommand implements CommandInterface
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }


}