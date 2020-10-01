<?php

namespace App\Application\Service\Uuid;

use Ramsey\Uuid\Uuid;

class UuidService
{
    public static function isValidUuidV6(string $uuid): bool
    {

        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $uuid) !== 1)) {
            return false;
        }

        return true;
    }

    public static function nextUuidV6(): string
    {
        return Uuid::uuid6()->toString();
    }
}
