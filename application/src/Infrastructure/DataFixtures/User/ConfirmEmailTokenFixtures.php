<?php

namespace App\Infrastructure\DataFixtures\User;

use App\Model\User\Entity\ConfirmEmailToken;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ConfirmEmailTokenFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $arrayTokens = [
            [
                "confirmationEmailToken" => "123",
                "email" => "test2@gmail.com",
                "user" => $this->getReference(UserFixtures::USER_TEST),
                "expires" => (new DateTimeImmutable())->modify("+2 hour")
            ],
            [
                "confirmationEmailToken" => "1237",
                "email" => "test2@gmail.com",
                "user" => $this->getReference(UserFixtures::USER_BLOCKED_TEST),
                "expires" => (new DateTimeImmutable())->modify("+2 hour")
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
