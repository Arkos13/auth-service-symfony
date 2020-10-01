<?php

namespace App\Model\User\Service\ConfirmEmailToken\Factory;

use App\Model\User\Entity\ConfirmEmailToken;
use App\Model\User\Repository\ConfirmEmailTokenRepositoryInterface;
use Exception;

abstract class ConfirmEmailTokenFactoryAbstract
{
    protected ConfirmEmailTokenRepositoryInterface $confirmEmailTokenRepository;

    public function __construct(ConfirmEmailTokenRepositoryInterface $confirmEmailTokenRepository)
    {
        $this->confirmEmailTokenRepository = $confirmEmailTokenRepository;
    }

    abstract protected function make(Data $data): ConfirmEmailToken;

    abstract protected function checkExistsConfirmToken(Data $data): ?ConfirmEmailToken;

    public function create(Data $data): ConfirmEmailToken
    {
        if (!($confirmEmailToken = $this->checkValidConfirmToken($data))) {
            $confirmEmailToken = $this->make($data);
            $this->confirmEmailTokenRepository->add($confirmEmailToken);
        }
        return $confirmEmailToken;
    }

    protected function checkValidConfirmToken($data): ?ConfirmEmailToken
    {
        if (($confirmEmailToken = $this->checkExistsConfirmToken($data))
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
