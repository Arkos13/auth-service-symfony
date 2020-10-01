<?php

namespace App\Infrastructure\DataFixtures\User;

use App\Model\User\Entity\User;
use App\Model\User\Entity\UserProfile;
use App\Application\Service\PasswordHasher\PasswordHasherInterface;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface
{
    public const USER_TEST = 'user-test-0';
    public const USER_BLOCKED_TEST = 'user-test-2';
    public const USER_ID_TEST = '1eaa6f9c-7cba-6e5e-80d9-0242c0a8de04';

    private PasswordHasherInterface $passwordHasher;

    public function __construct(PasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $arrayUsers = [
            [
                "id" => self::USER_ID_TEST,
                "email" => "test@gmail.com",
                "password" => $this->passwordHasher->hash("123456"),
                "confirmationToken" => null,
                "expiresConfirmationToken" => null,
                "firstName" => "First",
                "lastName" => "Last",
                "phone" => "1234567"
            ],
            [
                "id" => "1eaa6f9c-7cbe-63b0-961e-0242c0a8de04",
                "email" => "test1@gmail.com",
                "confirmationToken" => "123",
                "expiresConfirmationToken" => (new DateTimeImmutable())->modify("+2 hour"),
                "password" => "",
                "firstName" => "First",
                "lastName" => "Last",
                "phone" => null
            ],
            [
                "id" => "1eaa6f9c-7cbe-65e0-971e-0242c0a8de04",
                "email" => "test11@gmail.com",
                "confirmationToken" => "1235",
                "expiresConfirmationToken" => (new DateTimeImmutable())->modify("+2 hour"),
                "password" => "",
                "firstName" => "First",
                "lastName" => "Last",
                "phone" => null
            ]
        ];
        foreach ($arrayUsers as $key => $item) {
            $user = User::create($item["email"], $item["password"], $item["id"]);
            $user->setConfirmationToken($item["confirmationToken"]);
            $user->setExpiresConfirmationToken($item["expiresConfirmationToken"]);
            $user->setCreated(new DateTimeImmutable());
            $user->setUpdated(new DateTimeImmutable());
            $manager->persist($user);
            $this->addReference("user-test-{$key}", $user);

            $userProfile = UserProfile::create($user, $item["firstName"], $item["lastName"]);
            $userProfile->setPhone($item["phone"]);
            $userProfile->setCreated(new DateTimeImmutable());
            $userProfile->setUpdated(new DateTimeImmutable());
            $manager->persist($userProfile);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }

    public static function getGroups(): array
    {
        return ["users"];
    }
}
