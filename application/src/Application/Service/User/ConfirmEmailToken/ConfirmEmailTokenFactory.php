<?php

namespace App\Application\Service\User\ConfirmEmailToken;

use App\Model\User\Entity\ConfirmEmailToken;
use App\Model\User\Repository\ConfirmEmailTokenRepositoryInterface;
use DateTimeImmutable;
use Exception;

class ConfirmEmailTokenFactory extends ConfirmEmailTokenFactoryAbstract
{
    private const EXPIRES = "+2 hour";

    public function __construct(ConfirmEmailTokenRepositoryInterface $confirmEmailTokenRepository)
    {
        parent::__construct($confirmEmailTokenRepository);
    }

    /**
     * @param Data $data
     * @return ConfirmEmailToken
     * @throws Exception
     */
    protected function make(Data $data): ConfirmEmailToken
    {
        return ConfirmEmailToken::create(
            $data->user,
            $data->newEmail,
            $this->generateToken(),
            (new DateTimeImmutable())->modify(self::EXPIRES)
        );
    }

    protected function checkExistsConfirmToken(Data $data): ?ConfirmEmailToken
    {
        return $this->confirmEmailTokenRepository->findOneByUserAndEmail($data->user, $data->newEmail);
    }
}
