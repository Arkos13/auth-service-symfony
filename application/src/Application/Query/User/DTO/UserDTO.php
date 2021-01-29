<?php

namespace App\Application\Query\User\DTO;

use JMS\Serializer\Annotation as Serializer;
use Swagger\Annotations as SWG;

/**
 * @psalm-immutable
*/
class UserDTO
{
    /** @SWG\Property(property="id", type="string") */
    public string $id;

    /** @SWG\Property(property="email", type="string") */
    public string $email;

    /**
     * @SWG\Property(property="firstName", type="string")
     * @Serializer\SerializedName("firstName")
     */
    public string $firstName;

    /**
     * @SWG\Property(property="lastName", type="string")
     * @Serializer\SerializedName("lastName")
     */
    public string $lastName;

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


}