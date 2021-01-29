<?php

namespace App\Model\User\Entity;

use App\Model\Shared\Entity\Id;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user_profile_phone_confirm_codes")
 * @ORM\Entity()
 * @psalm-immutable
 */
class PhoneConfirmCode
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     */
    public string $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\User\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    public User $user;

    /**
     * @ORM\Column(name="code", type="integer")
     */
    public int $code;

    /**
     * @ORM\Column(name="expires_at", type="datetime_immutable")
     */
    public DateTimeImmutable $expiresAt;

    /**
     * @ORM\Column(type="string", length=50)U
     */
    public string $phone;

    private function __construct(string $id,
                                 int $code,
                                 User $user,
                                 DateTimeImmutable $expiresAt,
                                 string $phone)
    {
        $this->id = $id;
        $this->code = $code;
        $this->user = $user;
        $this->expiresAt = $expiresAt;
        $this->phone = $phone;
    }

    public static function create(Id $id,
                                  int $code,
                                  User $user,
                                  DateTimeImmutable $expiresAt,
                                  string $phone): PhoneConfirmCode
    {
        return new PhoneConfirmCode(
            $id->id,
            $code,
            $user,
            $expiresAt,
            $phone
        );
    }

    public function isValidExpiresToken(): bool
    {
        return $this->expiresAt->getTimestamp() >= (new DateTimeImmutable())->getTimestamp();
    }


}
