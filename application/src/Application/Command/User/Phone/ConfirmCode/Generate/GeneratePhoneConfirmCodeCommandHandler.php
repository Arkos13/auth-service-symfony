<?php

namespace App\Application\Command\User\Phone\ConfirmCode\Generate;

use App\Application\Command\CommandHandlerInterface;
use App\Application\Service\Sms\SmsInterface;
use App\Model\Shared\Entity\Id;
use App\Model\User\Entity\PhoneConfirmCode;
use App\Model\User\Repository\PhoneConfirmCodeRepositoryInterface;
use App\Model\User\Repository\UserRepositoryInterface;
use DateTimeImmutable;

class GeneratePhoneConfirmCodeCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userRepository;
    private PhoneConfirmCodeRepositoryInterface $repository;
    private SmsInterface $smsService;

    public function __construct(UserRepositoryInterface $userRepository,
                                PhoneConfirmCodeRepositoryInterface $repository,
                                SmsInterface $smsService)
    {
        $this->userRepository = $userRepository;
        $this->repository = $repository;
        $this->smsService = $smsService;
    }

    public function __invoke(GeneratePhoneConfirmCodeCommand $command): void
    {
        $user = $this->userRepository->getOneById($command->userId);

        $code = rand(1000, 9999);

        $this->repository->add(
            PhoneConfirmCode::create(
                Id::create(),
                $code,
                $user,
                new DateTimeImmutable("+10 minutes"),
                $command->phone
            )
        );

        $this->smsService->send(
            strval($code),
            ['+' . preg_replace('/\D/', '', $command->phone)]
        );
    }
}