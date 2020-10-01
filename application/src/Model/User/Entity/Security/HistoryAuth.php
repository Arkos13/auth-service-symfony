<?php

namespace App\Model\User\Entity\Security;

use App\Application\Service\Uuid\UuidService;
use App\Model\User\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user_history_auth")
 * @ORM\Entity()
*/
class HistoryAuth
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
     *  @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $created;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $countryCode = "";

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $countryName = "";

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $region = "";

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $city = "";

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $ip = "";

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $guid = "";

    private function __construct(string $id,
                                 User $user,
                                 ?string $city,
                                 ?string $countryCode,
                                 ?string $countryName,
                                 ?string $region,
                                 ?string $ip,
                                 ?string $guid)
    {
        $this->created = new DateTimeImmutable();
        $this->id = $id;
        $this->user = $user;
        $this->city = $city;
        $this->countryCode = $countryCode;
        $this->countryName = $countryName;
        $this->region = $region;
        $this->ip = $ip;
        $this->guid = $guid;
    }

    public static function create(User $user,
                                  ?string $city,
                                  ?string $countryCode,
                                  ?string $countryName,
                                  ?string $region,
                                  ?string $ip,
                                  ?string $guid): HistoryAuth
    {
        return new HistoryAuth(
            UuidService::nextUuidV6(),
            $user,
            $city,
            $countryCode,
            $countryName,
            $region,
            $ip,
            $guid
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

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function getGuid(): ?string
    {
        return $this->guid;
    }


}
