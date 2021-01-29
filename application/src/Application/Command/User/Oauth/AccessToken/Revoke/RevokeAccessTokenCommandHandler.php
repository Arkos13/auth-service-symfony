<?php

namespace App\Application\Command\User\Oauth\AccessToken\Revoke;

use App\Application\Command\CommandHandlerInterface;
use App\Model\OAuth\Repository\TokenRepositoryInterface;

class RevokeAccessTokenCommandHandler implements CommandHandlerInterface
{
    private TokenRepositoryInterface $repository;

    public function __construct(TokenRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RevokeAccessTokenCommand $command): void
    {
        $this->repository->revokeByAccessTokenId($command->id);
    }
}