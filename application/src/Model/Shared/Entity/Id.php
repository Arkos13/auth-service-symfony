<?php

namespace App\Model\Shared\Entity;

use Ramsey\Uuid\Uuid;

/**
 * @psalm-immutable
*/
class Id
{
    public string $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function create(string $id = ""): Id
    {
        return new Id(
            Id::isValidUuidV6($id) ? $id : Id::nextUuidV6()
        );
    }

    private static function isValidUuidV6(string $uuid): bool
    {

        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $uuid) !== 1) {
            return false;
        }

        return true;
    }

    private static function nextUuidV6(): string
    {
        return Uuid::uuid6()->toString();
    }
}