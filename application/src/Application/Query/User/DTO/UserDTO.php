<?php

namespace App\Application\Query\User\DTO;

use JMS\Serializer\Annotation as Serializer;
use Swagger\Annotations as SWG;

class UserDTO
{
    /** @SWG\Property(property="id", type="string") */
    private string $id;

    /** @SWG\Property(property="email", type="string") */
    private string $email;

    /**
     * @SWG\Property(property="firstName", type="string")
     * @Serializer\SerializedName("firstName")
     */
    private string $firstName;

    /**
     * @SWG\Property(property="lastName", type="string")
     * @Serializer\SerializedName("lastName")
     */
    private string $lastName;

    public function __construct(string $id,
                                string $email,
                                string $firstName,
                                string $lastName)
    {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }


}