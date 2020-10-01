<?php

namespace App\Application\Service\PasswordHasher;

interface PasswordHasherInterface
{
    public function hash(string $password, string $salt = ""): string;
    public function validate(string $password, string $hash): bool;
}
