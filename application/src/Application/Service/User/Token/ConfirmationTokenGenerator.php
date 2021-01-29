<?php

namespace App\Application\Service\User\Token;

use App\Model\User\Entity\User;
use App\Model\User\Repository\UserRepositoryInterface;
use DateTimeImmutable;
use Exception;

class ConfirmationTokenGenerator implements TokenGeneratorInterface
{
    private const EXPIRES = "+2 hour";

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $user
     * @return string
     * @throws Exception
     */
    public function generateConfirmationToken(User $user): string
    {
        $token = $this->generateToken();
        $user->setConfirmationToken($token);
        $user->setExpiresConfirmationToken((new DateTimeImmutable())->modify(self::EXPIRES));
        $this->userRepository->add($user);
        return $token;
    }

    /**
     * @return string
     * @throws Exception
     */
    private function generateToken(): string
    {
        return trim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
