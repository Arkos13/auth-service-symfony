<?php

namespace App\Infrastructure\Security\Voter\User\Profile;

use App\Model\User\Repository\UserProfileRepositoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserProfileVoter extends Voter
{
    public const EDIT_PHONE = 'edit_phone';

    private UserProfileRepositoryInterface $repository;

    public function __construct(UserProfileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function supports(string $attribute, $subject)
    {
        return in_array($attribute, [self::EDIT_PHONE]) && is_string($subject);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        switch ($attribute) {
            case self::EDIT_PHONE:
                return !$this->repository->findOneByPhone($subject);
        }
        return false;
    }
}
