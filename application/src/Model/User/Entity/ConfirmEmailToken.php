<?php

namespace App\Model\User\Entity;

use App\Application\Service\Uuid\UuidService;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user_confirm_email_tokens")
 */
class ConfirmEmailToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private string $id;

    /**
     * @ORM\Column(type="string")
    */
    private string $confirmationEmailToken = "";

    /**
     *  @ORM\Column(type="string")
     */
    private string $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\User\Entity\User")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private User $user;

    /**
     *  @ORM\Column(type="datetime_immutable")
     */
    private ?DateTimeImmutable $expires = null;

    private function __construct(User $user,
                                string $email,
                                string $confirmationEmailToken,
                                DateTimeImmutable $expires)
    {
        $this->id = UuidService::nextUuidV6();
        $this->user = $user;
        $this->email = $email;
        $this->confirmationEmailToken = $confirmationEmailToken;
        $this->expires = $expires;
    }

    public static function create(User $user,
                                  string $email,
                                  string $confirmationEmailToken,
                                  DateTimeImmutable $expires): ConfirmEmailToken
    {
        return new ConfirmEmailToken($user, $email, $confirmationEmailToken, $expires);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getConfirmationEmailToken(): string
    {
        return $this->confirmationEmailToken;
    }

    public function isValidExpiresToken(): bool
    {
        return $this->getExpires()->getTimestamp() >= (new DateTimeImmutable())->getTimestamp();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getExpires(): ?DateTimeImmutable
    {
        return $this->expires;
    }


}
