<?php

namespace App\Infrastructure\Shared\Persistence\DataFixtures\User;

use App\Model\User\Entity\ConfirmEmailToken;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ConfirmEmailTokenFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface
{
    const TOKEN_TEST = "123";
    const EMAIL_TEST = "test2@gmail.com";
    const TOKEN_INVALID_TEST = "1234";
    const TOKEN_CLOCKED_USER_TEST = "1237";

    public function load(ObjectManager $manager)
    {
        $arrayTokens = [
            [
                "confirmationEmailToken" => self::TOKEN_TEST,
                "email" => self::EMAIL_TEST,
                "user" => $this->getReference(UserFixtures::USER_TEST),
                "expires" => (new DateTimeImmutable())->modify("+2 year")
            ],
            [
                "confirmationEmailToken" => self::TOKEN_INVALID_TEST,
                "email" => "test2@gmail.com",
                "user" => $this->getReference(UserFixtures::USER_TEST),
                "expires" => (new DateTimeImmutable())->modify("-2 year")
            ],
            [
                "confirmationEmailToken" => self::TOKEN_CLOCKED_USER_TEST,
                "email" => "test2@gmail.com",
                "user" => $this->getReference(UserFixtures::USER_TEST_2),
                "expires" => (new DateTimeImmutable())->modify("+2 year")
            ]
        ];
        foreach ($arrayTokens as $key => $item) {
            $token = ConfirmEmailToken::create(
                $item["user"],
                $item["email"],
                $item["confirmationEmailToken"],
                $item["expires"],
            );
            $manager->persist($token);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 7;
    }

    public static function getGroups(): array
    {
        return ["users"];
    }
}
