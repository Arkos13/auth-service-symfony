<?php

namespace App\Model\User\Entity;

use App\Model\Shared\Entity\Id;
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
     * @psalm-readonly
     */
    public string $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\User\Entity\User", inversedBy="networks")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @psalm-readonly
     */
    public User $user;

    /**
     * @ORM\Column(type="string")
     * @psalm-readonly
     */
    public string $network;

    /**
     * @ORM\Column(type="string")
     * @psalm-readonly
     */
    public string $identifier;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Exclude()
     * @psalm-readonly-allow-private-mutation
     */
    public ?string $accessToken;

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

    public static function create(Id $id,
                                  User $user,
                                  string $identifier,
                                  string $network,
                                  ?string $accessToken = null): Network
    {
        return new Network($id->id, $user, $identifier, $network, $accessToken);
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
