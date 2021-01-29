<?php

namespace App\Application\Command\User\Email\SendChangeInvite;

use App\Application\Command\CommandInterface;

/**
 * @psalm-immutable
*/
class SendChangeInviteCommand implements CommandInterface
{
    public string $email;
    public string $newEmail;
    public string $url;

    public function __construct(string $email, string $newEmail, string $url)
    {
        $this->email = $email;
        $this->newEmail = $newEmail;
        $this->url = $url;
    }


}