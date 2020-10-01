<?php

namespace App\Model\User\Entity;

use App\Application\Service\Uuid\UuidService;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user_networks")
 */
class Network
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private string $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\User\Entity\User")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private User $user;

    /**
     * @ORM\Column(type="string")
     */
    private string $network;

    /**
     * @ORM\Column(type="string")
     */
    private string $identifier;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Exclude()
     */
    private ?string $accessToken;

    public function __construct(string $id,
                                User $user,
                                string $identifier,
                                string $network,
                                ?string $accessToken)
    {
        $this->id = $id;
        $this->user = $user;
        $this->identifier = $identifier;
        $this->network = $network;
        $this->accessToken = $accessToken;
    }

    public static function create(User $user,
                                  string $identifier,
                                  string $network,
                                  ?string $accessToken = null,
                                  string $id = ''): Network
    {
        $id = UuidService::isValidUuidV6($id) ? $id : UuidService::nextUuidV6();
        return new Network($id, $user, $identifier, $network, $accessToken);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getNetwork(): string
    {
        return $this->network;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setAccessToken(?string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return array<string>
     */
    public static function getNetworks(): array
    {
        return ["facebook", "google"];
    }
}
