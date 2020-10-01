<?php

namespace App\Tests\Unit\CommonServices;

use App\Application\Service\PasswordHasher\PasswordHasherArgon2i;
use PHPUnit\Framework\TestCase;

class PasswordHasherArgon2iTest extends TestCase
{
    public function testCreate(): void
    {
        $hasher = new PasswordHasherArgon2i();
        $this->assertInstanceOf(PasswordHasherArgon2i::class, $hasher);
    }

    public function testGenerateHash(): void
    {
        $hasher = new PasswordHasherArgon2i();
        $password = "test";
        $hash = $hasher->hash($password);
        $this->assertIsString($hash);
        $this->assertNotSame(
            password_hash($password, PASSWORD_ARGON2I),
            $hash
        );
    }

    public function testValidateHash(): void
    {
        $hasher = new PasswordHasherArgon2i();
        $password = "test";
        $hash = $hasher->hash($password);
        $this->assertTrue($hasher->validate($password, $hash));
        $this->assertFalse($hasher->validate($password . "1", $hash));
    }
}
