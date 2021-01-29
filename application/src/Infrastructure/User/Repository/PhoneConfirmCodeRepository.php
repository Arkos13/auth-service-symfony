<?php

namespace App\Infrastructure\User\Repository;

use App\Model\User\Entity\PhoneConfirmCode;
use App\Model\User\Repository\PhoneConfirmCodeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class PhoneConfirmCodeRepository implements PhoneConfirmCodeRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findOneByUserIdAndCode(string $userId, int $code): ?PhoneConfirmCode
    {
        return $this->em
            ->getRepository(PhoneConfirmCode::class)
            ->findOneBy(["user" => $userId, "code" => $code]);
    }

    public function remove(PhoneConfirmCode $code): void
    {
        $this->em->remove($code);
        $this->em->flush();
    }

    public function add(PhoneConfirmCode $code): void
    {
        $this->em->persist($code);
        $this->em->flush();
    }
}
