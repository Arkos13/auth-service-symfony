<?php

namespace App\Infrastructure\Shared\Persistence\DataFixtures\User;

use App\Application\Service\PasswordHasher\PasswordHasherInterface;
use App\Model\User\Entity\ConfirmPasswordToken;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ConfirmPasswordTokenFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface
{
    const VALID_TOKEN = "123";
    const INVALID_TOKEN = "1237";

    private PasswordHasherInterface $passwordHasher;

    public function __construct(PasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $arrayTokens = [
            [
                "confirmationEmailToken" => self::VALID_TOKEN,
                "user" => $this->getReference(UserFixtures::USER_TEST),
                "expires" => (new DateTimeImmutable())->modify("+2 year")
            ],
            [
                "confirmationEmailToken" => self::INVALID_TOKEN,
                "user" => $this->getReference(UserFixtures::USER_TEST),
                "expires" => (new DateTimeImmutable())->modify("-2 year")
            ],
        ];
        foreach ($arrayTokens as $key => $item) {
            $token = ConfirmPasswordToken::create(
                $item["user"],
                $item["confirmationEmailToken"],
                $item["expires"],
            );
            $manager->persist($token);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }

    public static function getGroups(): array
    {
        return ["users"];
    }
}
