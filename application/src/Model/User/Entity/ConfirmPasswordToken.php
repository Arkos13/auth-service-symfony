<?php

namespace App\Model\User\Entity;

use App\Model\Shared\Entity\Id;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user_confirm_password_tokens")
 * @psalm-immutable
 */
class ConfirmPasswordToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    public string $id;

    /**
     * @ORM\Column(type="string")
     */
    public string $confirmationEmailToken;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\User\Entity\User")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    public User $user;

    /**
     *  @ORM\Column(type="datetime_immutable")
     */
    public DateTimeImmutable $expires;

    private function __construct(User $user,
                                 string $confirmationEmailToken,
                                 DateTimeImmutable $expires)
    {
        $this->id = Id::create()->id;
        $this->user = $user;
        $this->confirmationEmailToken = $confirmationEmailToken;
        $this->expires = $expires;
    }

    public static function create(User $user,
                                  string $confirmationEmailToken,
                                  DateTimeImmutable $expires): ConfirmPasswordToken
    {
        return new ConfirmPasswordToken($user, $confirmationEmailToken, $expires);
    }

    public function isValidExpiresToken(): bool
    {
        return $this->expires->getTimestamp() >= (new DateTimeImmutable())->getTimestamp();
    }


}
