<?php

namespace App\Application\Service\Mail;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class MailService implements MailServiceInterface
{
    private MailerInterface $mailer;

    private string $mailerSenderAddress;

    public function __construct(MailerInterface $mailer, string $mailerSenderAddress)
    {
        $this->mailer = $mailer;
        $this->mailerSenderAddress = $mailerSenderAddress;
    }

    /**
     * @param string $email
     * @param string $title
     * @param string $content
     * @param bool $isTemplate
     * @param array<mixed> $params
     * @throws TransportExceptionInterface
     */
    public function sendEmail(string $email,
                              string $title,
                              string $content,
                              bool $isTemplate = false,
                              array $params = []): void
    {
        $message = (new TemplatedEmail())
            ->subject($title)
            ->from($this->mailerSenderAddress)
            ->to($email);

        if($isTemplate) {
            $message->htmlTemplate($content)->context($params);
        } else {
            $message->text($content);
        }
        $this->mailer->send($message);
    }
}
