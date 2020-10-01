<?php

namespace App\Model\User\Entity;

use App\Application\Service\Uuid\UuidService;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user_profile_phone_confirm_codes")
 * @ORM\Entity()
 */
class PhoneConfirmCode
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     */
    private string $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\User\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private User $user;

    /**
     * @ORM\Column(name="code", type="integer")
     */
    private int $code;

    /**
     * @ORM\Column(name="expires_at", type="datetime_immutable")
     */
    private DateTimeImmutable $expiresAt;

    /**
     * @ORM\Column(type="string", length=50)U
     */
    private string $phone;

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

    public static function create(int $code,
                                  User $user,
                                  DateTimeImmutable $expiresAt,
                                  string $phone,
                                  string $id = ''): PhoneConfirmCode
    {
        return new PhoneConfirmCode(
            UuidService::isValidUuidV6($id) ? $id : UuidService::nextUuidV6(),
            $code,
            $user,
            $expiresAt,
            $phone
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getExpiresAt(): DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function isValidExpiresToken(): bool
    {
        return $this->getExpiresAt()->getTimestamp() >= (new DateTimeImmutable())->getTimestamp();
    }

    public function getPhone(): string
    {
        return $this->phone;
    }


}
