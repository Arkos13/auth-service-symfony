<?php

namespace App\Model\User\Entity;

use App\Application\Service\Uuid\UuidService;
use App\Model\Shared\Entity\CreatedUpdatedTrait;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="email_idx", columns={"email"})})
 */
class User implements UserInterface
{
    use CreatedUpdatedTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
    */
    private string $id;

    /**
     * @ORM\Column(name="email", type="string")
     */
    private string $email;

    /**
     * @ORM\Column(name="password", type="string")
     * @JMS\Exclude()
     */
    private string $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @JMS\Exclude()
     */
    private ?string $confirmationToken = null;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @JMS\Exclude()
     */
    private ?DateTimeImmutable $expiresConfirmationToken = null;

    private function __construct(string $id, string $email, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }

    public static function create(string $email, string $password, string $id = ''): User
    {
        return new User(
            UuidService::isValidUuidV6($id) ? $id : UuidService::nextUuidV6(),
            $email,
            $password
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;
    }

    public function getExpiresConfirmationToken(): ?DateTimeImmutable
    {
        return $this->expiresConfirmationToken;
    }

    public function isValidExpiresConfirmationToken(): bool
    {
        if (!$this->getExpiresConfirmationToken()) {
            return false;
        }

        return $this->getExpiresConfirmationToken()->getTimestamp() >= (new DateTimeImmutable())->getTimestamp();
    }

    public function setExpiresConfirmationToken(?DateTimeImmutable $expiresConfirmationToken): void
    {
        $this->expiresConfirmationToken = $expiresConfirmationToken;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function getSalt(): string
    {
        return "";
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }
}
