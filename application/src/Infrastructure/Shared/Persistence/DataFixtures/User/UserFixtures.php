<?php

namespace App\Infrastructure\Shared\Persistence\DataFixtures\User;

use App\Model\Shared\Entity\Id;
use App\Model\User\Entity\User;
use App\Application\Service\PasswordHasher\PasswordHasherInterface;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface
{
    public const USER_TEST = 'user-test-0';
    public const USER_EMAIL_TEST = 'test@gmail.com';
    public const USER_TEST_2 = 'user-test-2';
    public const USER_ID_TEST = '1eaa6f9c-7cba-6e5e-80d9-0242c0a8de04';

    public const USER_EMAIL_TEST_2 = "test1@gmail.com";
    public const USER_CONFIRM_TOKEN_2 = "123";

    public const USER_EMAIL_TEST_3 = "test11@gmail.com";
    public const USER_CONFIRM_TOKEN_3 = "1235";

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
                "email" => self::USER_EMAIL_TEST,
                "password" => $this->passwordHasher->hash("123456"),
                "confirmationToken" => null,
                "expiresConfirmationToken" => null,
                "firstName" => "First",
                "lastName" => "Last",
                "phone" => "1234567"
            ],
            [
                "id" => "1eaa6f9c-7cbe-63b0-961e-0242c0a8de04",
                "email" => self::USER_EMAIL_TEST_2,
                "confirmationToken" => self::USER_CONFIRM_TOKEN_2,
                "expiresConfirmationToken" => (new DateTimeImmutable())->modify("+2 hour"),
                "password" => $this->passwordHasher->hash("123456"),
                "firstName" => "First",
                "lastName" => "Last",
                "phone" => null
            ],
            [
                "id" => "1eaa6f9c-7cbe-65e0-971e-0242c0a8de04",
                "email" => self::USER_EMAIL_TEST_3,
                "confirmationToken" => self::USER_CONFIRM_TOKEN_3,
                "expiresConfirmationToken" => (new DateTimeImmutable())->modify("-2 hour"),
                "password" => $this->passwordHasher->hash("123456"),
                "firstName" => "First",
                "lastName" => "Last",
                "phone" => null
            ]
        ];
        foreach ($arrayUsers as $key => $item) {
            $user = User::create(
                Id::create($item["id"]),
                $item["email"],
                $item["password"],
                $item["firstName"],
                $item["lastName"]
            );
            $user->setConfirmationToken($item["confirmationToken"]);
            $user->setExpiresConfirmationToken($item["expiresConfirmationToken"]);
            $user->setPhone($item["phone"] ?? "");
            $manager->persist($user);
            $this->addReference("user-test-{$key}", $user);
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
