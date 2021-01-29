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
     * @ORM\OneToOne(targetEntity="App\Model\User\Entity\User", inversedBy="profile")
     * @ORM\JoinColumn(name="user_id", nullable=false, onDelete="CASCADE")
     * @Serializer\Exclude()
     * @psalm-readonly
     */
    public User $user;

    /**
     * @ORM\Column(type="string")
     * @Serializer\SerializedName("firstName")
     * @psalm-readonly-allow-private-mutation
     */
    public string $firstName;

    /**
     * @ORM\Column(type="string")
     * @Serializer\SerializedName("lastName")
     * @psalm-readonly-allow-private-mutation
     */
    public string $lastName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @psalm-readonly-allow-private-mutation
     */
    public ?string $phone;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @psalm-readonly-allow-private-mutation
     */
    public ?DateTimeImmutable $birthday;

    /**
     * @ORM\Column(type="string", nullable=true, length=10)
     * @psalm-readonly-allow-private-mutation
     */
    public ?string $gender;

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

    public function getUserId(): string
    {
        return $this->user->id;
    }

    public function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function editProfile(string $firstName,
                                string $lastName,
                                ?DateTimeImmutable $birthday,
                                ?string $gender): void
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthday = $birthday;
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
