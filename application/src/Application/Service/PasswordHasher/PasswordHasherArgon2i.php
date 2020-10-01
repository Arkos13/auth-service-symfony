<?php

namespace App\Application\Service\PasswordHasher;

use SodiumException;

class PasswordHasherArgon2i implements PasswordHasherInterface
{

    /**
     * @param string $password
     * @param string $salt
     * @return string
     * @throws SodiumException
     */
    public function hash(string $password, string $salt = ""): string
    {
        return sodium_crypto_pwhash_str(
            $password,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
        );
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     * @throws SodiumException
     */
    public function validate(string $password, string $hash): bool
    {
        return sodium_crypto_pwhash_str_verify($hash, $password);
    }
}
