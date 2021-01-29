<?php

namespace App\Model\User\ReadModel;

use InvalidArgumentException;

/**
 * @psalm-immutable
*/
class UserAuthDTO
{
    public string $id;
    public string $email;
    public string $password;
    public ?string $confirmationToken;

    private function __construct(string $id, string $email, string $password, ?string $confirmationToken)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * @param array<string, mixed> $data
     * @return UserAuthDTO
     */
    public static function fromArray(array $data): UserAuthDTO
    {
        if (!UserAuthDTO::checkData($data)) {
            throw new InvalidArgumentException("The input data is not valid");
        }

        return new UserAuthDTO(
            $data["id"],
            $data["email"],
            $data["password"],
            $data["confirmation_token"],
        );
    }

    /**
     * @param array<string, mixed> $data
     * @return bool
     */
    private static function checkData(array $data): bool
    {
        return isset(
            $data["id"],
            $data["email"],
            $data["password"],
        );
    }
}