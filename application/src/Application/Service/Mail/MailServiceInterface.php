<?php

namespace App\Application\Service\Mail;

interface MailServiceInterface
{
    /**
     * @param string $email
     * @param string $title
     * @param string $content
     * @param bool $isTemplate
     * @param array<mixed> $params
     */
    public function sendEmail(string $email,
                              string $title,
                              string $content,
                              bool $isTemplate = false,
                              array $params = []): void;
}
