<?php

namespace App\Application\Service\User\ConfirmPasswordToken;

use App\Model\User\Entity\ConfirmPasswordToken;
use App\Model\User\Entity\User;
use App\Model\User\Repository\ConfirmPasswordTokenRepositoryInterface;
use Exception;

abstract class ConfirmPasswordTokenFactoryAbstract
{
    protected ConfirmPasswordTokenRepositoryInterface $repository;

    public function __construct(ConfirmPasswordTokenRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    abstract protected function make(User $user): ConfirmPasswordToken;

    abstract protected function checkExistsConfirmToken(User $user): ?ConfirmPasswordToken;

    public function create(User $user): ConfirmPasswordToken
    {
        if (!($confirmEmailToken = $this->checkValidConfirmToken($user))) {
            $confirmEmailToken = $this->make($user);
            $this->repository->add($confirmEmailToken);
        }
        return $confirmEmailToken;
    }

    protected function checkValidConfirmToken(User $user): ?ConfirmPasswordToken
    {
        if (($confirmEmailToken = $this->checkExistsConfirmToken($user))
            && $confirmEmailToken->isValidExpiresToken()) {
            return $confirmEmailToken;
        }
        return null;
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function generateToken(): string
    {
        return trim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
