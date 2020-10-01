<?php

namespace App\Application\Service\Sms;

interface SmsInterface
{
    /**
     * @param string $text
     * @param array<string> $phones
     */
    public function send(string $text, array $phones): void;
}
