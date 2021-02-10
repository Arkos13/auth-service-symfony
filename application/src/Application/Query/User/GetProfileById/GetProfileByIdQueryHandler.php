<?php

namespace App\Application\Query\User\GetProfileById;

use App\Application\Query\QueryHandlerInterface;
use App\Model\User\Entity\UserProfile;
use App\Model\User\Repository\UserRepositoryInterface;

class GetProfileByIdQueryHandler implements QueryHandlerInterface
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetProfileByIdQuery $query): UserProfile
    {
        return $this->repository->getOneById($query->id)->profile;
    }
}