<?php

namespace App\Application\Service\User\ConfirmEmailToken;

use App\Model\User\Entity\ConfirmEmailToken;
use App\Model\User\Repository\ConfirmEmailTokenRepositoryInterface;
use App\Model\User\Service\ConfirmEmailToken\Factory\ConfirmEmailTokenFactoryAbstract;
use App\Model\User\Service\ConfirmEmailToken\Factory\Data;
use App\Model\User\Service\Token\TokenGeneratorInterface;
use DateTimeImmutable;
use Exception;

class ConfirmEmailTokenFactory extends ConfirmEmailTokenFactoryAbstract
{
    private const EXPIRES = "+2 hour";

    private TokenGeneratorInterface $tokenGenerator;

    public function __construct(TokenGeneratorInterface $tokenGenerator,
                                ConfirmEmailTokenRepositoryInterface $confirmEmailTokenRepository)
    {
        parent::__construct($confirmEmailTokenRepository);
        $this->tokenGenerator = $tokenGenerator;
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
