<?php

namespace App\Application\Service\User\Phone;

use App\Model\User\Entity\User;
use App\Model\User\Exception\PhoneConfirmCodeExpiredException;
use App\Model\User\Exception\PhoneConfirmCodeNotFoundException;
use App\Model\User\Repository\PhoneConfirmCodeRepositoryInterface;
use App\Model\User\Service\UserProfile\PhoneConfirmCode\CheckConfirmCodeInterface;

class CheckConfirmCode implements CheckConfirmCodeInterface
{
    private PhoneConfirmCodeRepositoryInterface $phoneConfirmCodeRepository;

    public function __construct(PhoneConfirmCodeRepositoryInterface $phoneConfirmCodeRepository)
    {
        $this->phoneConfirmCodeRepository = $phoneConfirmCodeRepository;
    }

    public function checkCode(User $user, int $code): string
    {
        $code = $this->phoneConfirmCodeRepository->findOneByUserIdAndCode($user->getId(), $code);

        if (!$code) {
            throw new PhoneConfirmCodeNotFoundException();
        }

        if (!$code->isValidExpiresToken()) {
            throw new PhoneConfirmCodeExpiredException();
        }

        $phone = $code->getPhone();
        $this->phoneConfirmCodeRepository->remove($code);

        return $phone;
    }
}
