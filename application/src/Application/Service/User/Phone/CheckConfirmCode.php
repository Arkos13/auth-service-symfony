<?php

namespace App\Application\Service\User\Phone;

use App\Model\User\Exception\PhoneConfirmCodeExpiredException;
use App\Model\User\Exception\PhoneConfirmCodeNotFoundException;
use App\Model\User\Repository\PhoneConfirmCodeRepositoryInterface;

class CheckConfirmCode implements CheckConfirmCodeInterface
{
    private PhoneConfirmCodeRepositoryInterface $phoneConfirmCodeRepository;

    public function __construct(PhoneConfirmCodeRepositoryInterface $phoneConfirmCodeRepository)
    {
        $this->phoneConfirmCodeRepository = $phoneConfirmCodeRepository;
    }

    public function checkCode(string $userId, int $code): string
    {
        $code = $this->phoneConfirmCodeRepository->findOneByUserIdAndCode($userId, $code);

        if (!$code) {
            throw new PhoneConfirmCodeNotFoundException();
        }

        if (!$code->isValidExpiresToken()) {
            throw new PhoneConfirmCodeExpiredException();
        }

        $phone = $code->phone;
        $this->phoneConfirmCodeRepository->remove($code);

        return $phone;
    }
}
