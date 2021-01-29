<?php

namespace App\Application\Service\Sms;

class FakeSmsService implements SmsInterface
{

    /**
     * @param string $text
     * @param array<string> $phones
     */
    public function send(string $text, array $phones): void
    {
    }
}
