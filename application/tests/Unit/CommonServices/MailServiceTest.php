<?php

namespace App\Tests\Unit\CommonServices;

use App\Application\Service\Mail\MailService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;

class MailServiceTest extends TestCase
{
    private MailService $mailService;

    public function setUp(): void
    {
        parent::setUp();
        $mailer = $this->createMock(MailerInterface::class);
        $this->mailService = new MailService($mailer, "test@gmail.com");
    }

    public function testSendSimpleMail(): void
    {
        $this->mailService->sendEmail("test2@gmail.com", "test", "test", false);
        $this->assertTrue(true);
    }

    public function testSendTemplateMail(): void
    {
        $this->mailService->sendEmail("test2@gmail.com", "test", "base.html.twig", true);
        $this->assertTrue(true);
    }
}
