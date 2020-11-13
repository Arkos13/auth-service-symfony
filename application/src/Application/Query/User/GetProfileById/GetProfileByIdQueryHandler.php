<?php

namespace App\Application\Query\User\GetProfileById;

use App\Application\Query\QueryHandlerInterface;
use App\Model\User\Entity\UserProfile;
use App\Model\User\Repository\UserProfileRepositoryInterface;

class GetProfileByIdQueryHandler implements QueryHandlerInterface
{
    private UserProfileRepositoryInterface $repository;

    public function __construct(UserProfileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetProfileByIdQuery $query): UserProfile
    {
        return $this->repository->getOneByUserId($query->id);
    }
}