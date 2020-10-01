<?php

namespace App\Infrastructure\Repository\User;

use App\Model\User\Entity\PhoneConfirmCode;
use App\Model\User\Repository\PhoneConfirmCodeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @method PhoneConfirmCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhoneConfirmCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhoneConfirmCode[]    findAll()
 * @method PhoneConfirmCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhoneConfirmCodeRepository extends ServiceEntityRepository implements PhoneConfirmCodeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhoneConfirmCode::class);
    }

    public function findOneByUserIdAndCode(string $userId, int $code): ?PhoneConfirmCode
    {
        return $this->findOneBy(["user" => $userId, "code" => $code]);
    }

    /**
     * @param PhoneConfirmCode $code
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(PhoneConfirmCode $code): void
    {
        $this->getEntityManager()->remove($code);
        $this->getEntityManager()->flush();
    }

    /**
     * @param PhoneConfirmCode $code
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PhoneConfirmCode $code): void
    {
        $this->getEntityManager()->persist($code);
        $this->getEntityManager()->flush();
    }
}
