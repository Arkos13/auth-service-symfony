<?php

namespace App\Application\Command\User\Phone\ConfirmCode\Generate;

use App\Application\Service\Sms\SmsInterface;
use App\Model\User\Entity\PhoneConfirmCode;
use App\Model\User\Repository\PhoneConfirmCodeRepositoryInterface;
use App\Model\User\Repository\UserRepositoryInterface;
use DateTimeImmutable;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GeneratePhoneConfirmCodeCommandHandler implements MessageHandlerInterface
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

    /**
     * @param GeneratePhoneConfirmCodeCommand $command
     * @throws EntityNotFoundException
     */
    public function __invoke(GeneratePhoneConfirmCodeCommand $command): void
    {
        if (!($user = $this->userRepository->findOneById($command->getUserId()))) {
            throw new EntityNotFoundException("User not found");
        }

        $code = rand(1000, 9999);

        $this->repository->add(
            PhoneConfirmCode::create(
                $code,
                $user,
                new DateTimeImmutable("+10 minutes"),
                $command->getPhone()
            )
        );

        $this->smsService->send(
            strval($code),
            ['+' . preg_replace('/\D/', '', $command->getPhone())]
        );
    }
}