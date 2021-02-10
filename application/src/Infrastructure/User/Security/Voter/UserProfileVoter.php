<?php

namespace App\Infrastructure\User\Security\Voter;

use App\Model\User\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserProfileVoter extends Voter
{
    public const EDIT_PHONE = 'edit_phone';

    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
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
                return !$this->repository->checkExistsPhone($subject);
        }
        return false;
    }
}
