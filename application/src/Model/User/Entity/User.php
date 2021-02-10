<?php

namespace App\Model\User\Entity;

use App\Model\Shared\Entity\CreatedUpdatedTrait;
use App\Model\Shared\Entity\Id;
use App\Model\Shared\Event\DomainEvents;
use App\Model\User\Event\ChangedPasswordEvent;
use App\Model\User\Event\EditedUserEmailEvent;
use App\Model\User\Event\EditedUserPhoneEvent;
use App\Model\User\Event\EditedUserProfileEvent;
use App\Model\User\Event\RegisteredUserEvent;
use App\Model\User\Event\RegisteredUserViaNetworkEvent;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="email_idx", columns={"email"})})
 */
class User
{
    use CreatedUpdatedTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @psalm-readonly
     */
    public string $id;

    /**
     * @ORM\Column(name="email", type="string")
     * @psalm-readonly-allow-private-mutation
     */
    public string $email;

    /**
     * @ORM\Column(name="password", type="string")
     * @JMS\Exclude()
     * @psalm-readonly-allow-private-mutation
     */
    public string $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @JMS\Exclude()
     * @psalm-readonly-allow-private-mutation
     */
    public ?string $confirmationToken = null;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @JMS\Exclude()
     * @psalm-readonly-allow-private-mutation
     */
    public ?DateTimeImmutable $expiresConfirmationToken = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Model\User\Entity\UserProfile", mappedBy="user", cascade={"persist"})
     * @JMS\Exclude()
     * @psalm-readonly-allow-private-mutation
     */
    public UserProfile $profile;

    /**
     * @ORM\OneToMany (targetEntity="App\Model\User\Entity\Network", mappedBy="user", cascade={"persist"}, fetch="EXTRA_LAZY")
     * @JMS\Exclude()
     * @psalm-readonly-allow-private-mutation
     * @var Collection<int, Network>
     */
    public Collection $networks;

    private function __construct(string $id, string $email, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->networks = new ArrayCollection();
    }

    public static function create(Id $id, string $email, string $password, string $firstName, string $lastName): User
    {
        $user = new User(
            $id->id,
            $email,
            $password,
        );
        $user->profile = UserProfile::create($user, $firstName, $lastName);
        DomainEvents::apply(new RegisteredUserEvent($user->email));
        return $user;
    }

    public static function createByNetwork(Id $id,
                                           string $email,
                                           string $hashPassword,
                                           string $originPassword,
                                           string $firstName,
                                           string $lastName,
                                           string $networkIdentifier,
                                           string $network,
                                           ?string $networkAccessToken = null): User
    {
        $user = new User(
            $id->id,
            $email,
            $hashPassword,
        );
        $user->profile = UserProfile::create($user, $firstName, $lastName);
        $user->addNetwork($networkIdentifier, $network, $networkAccessToken);

        DomainEvents::apply(new RegisteredUserViaNetworkEvent(
            $user->email,
            $originPassword
        ));

        return $user;
    }

    public function setEmail(string $email): void
    {
        DomainEvents::apply(
            new EditedUserEmailEvent(
                $this->email,
                $email
            )
        );

        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
        DomainEvents::apply(new ChangedPasswordEvent($this->email));
    }

    public function setPhone(string $phone): void
    {
        $this->profile->setPhone($phone);
        DomainEvents::apply(new EditedUserPhoneEvent($this->email, $phone));
    }

    public function editProfile(string $firstName,
                                string $lastName,
                                ?DateTimeImmutable $birthday,
                                ?string $gender): void
    {
        $this->profile->editProfile($firstName, $lastName, $birthday, $gender);
        DomainEvents::apply(
            new EditedUserProfileEvent(
                $this->email,
                $firstName,
                $lastName,
                $birthday ? $birthday->format('Y-m-d H:i:s') : null,
                $gender
            )
        );
    }

    public function addNetwork(string $identifier,
                               string $network,
                               ?string $accessToken = null): void
    {
        $this->networks->add(
            Network::create(
                Id::create(),
                $this,
                $identifier,
                $network,
                $accessToken,
            )
        );
    }

    public function setConfirmationToken(?string $confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;
    }

    public function isValidExpiresConfirmationToken(): bool
    {
        if (!$this->expiresConfirmationToken) {
            return false;
        }

        return $this->expiresConfirmationToken->getTimestamp() >= (new DateTimeImmutable())->getTimestamp();
    }

    public function setExpiresConfirmationToken(?DateTimeImmutable $expiresConfirmationToken): void
    {
        $this->expiresConfirmationToken = $expiresConfirmationToken;
    }


}
