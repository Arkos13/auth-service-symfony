<?php

namespace App\Model\User\Entity;

use App\Model\Shared\Entity\CreatedUpdatedTrait;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user_profiles")
 */
class UserProfile
{
    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';

    use CreatedUpdatedTrait;

    /**
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="App\Model\User\Entity\User")
     * @ORM\JoinColumn(name="user_id", nullable=false, onDelete="CASCADE")
     * @Serializer\Exclude()
     */
    private User $user;

    /**
     * @ORM\Column(type="string")
     * @Serializer\SerializedName("firstName")
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string")
     * @Serializer\SerializedName("lastName")
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private ?string $phone;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $birthday;

    /**
     * @ORM\Column(type="string", nullable=true, length=10)
     */
    private ?string $gender;

    private function __construct(User $user, string $firstName, string $lastName)
    {
        $this->user = $user;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public static function create(User $user, string $firstName, string $lastName): UserProfile
    {
        return new UserProfile($user, $firstName, $lastName);
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getBirthday(): ?DateTimeImmutable
    {
        return $this->birthday;
    }

    public function setBirthday(?DateTimeImmutable $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return array<mixed>
     */
    public static function getGenderValues(): array
    {
        return [self::GENDER_MALE, self::GENDER_FEMALE, null];
    }


}
