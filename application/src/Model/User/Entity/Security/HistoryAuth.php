<?php

namespace App\Model\User\Entity\Security;

use App\Model\Shared\Entity\Id;
use App\Model\User\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user_history_auth")
 * @ORM\Entity()
 * @psalm-immutable
*/
class HistoryAuth
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
     *  @ORM\Column(type="datetime_immutable")
     */
    public DateTimeImmutable $created;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $countryCode;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $countryName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $region;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $ip;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $guid;

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
        $this->city = $city ?? "";
        $this->countryCode = $countryCode ?? "";
        $this->countryName = $countryName ?? "";
        $this->region = $region ?? "";
        $this->ip = $ip ?? "";
        $this->guid = $guid ?? "";
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
            Id::create()->id,
            $user,
            $city,
            $countryCode,
            $countryName,
            $region,
            $ip,
            $guid
        );
    }


}
