<?php

namespace App\Infrastructure\Shared\Persistence\DataFixtures\User;

use App\Model\Shared\Entity\Id;
use App\Model\User\Entity\PhoneConfirmCode;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PhoneConfirmCodeFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface
{
    public const CODE_TEST = '3333';
    public const CODE_TEST_INVALID = '3335';

    public function load(ObjectManager $manager)
    {
        $arrayUsers = [
            [
                "user" => $this->getReference(UserFixtures::USER_TEST),
                "code" => self::CODE_TEST,
                "phone" => "12345670",
                "expiresAt" => new DateTimeImmutable("+1 year")
            ],
            [
                "user" => $this->getReference(UserFixtures::USER_TEST),
                "code" => self::CODE_TEST_INVALID,
                "phone" => "12345670",
                "expiresAt" => new DateTimeImmutable("-10 minutes")
            ],
        ];
        foreach ($arrayUsers as $key => $item) {
            $code = PhoneConfirmCode::create(
                Id::create(),
                $item["code"],
                $item["user"],
                $item["expiresAt"],
                $item["phone"],
            );
            $manager->persist($code);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 9;
    }

    public static function getGroups(): array
    {
        return ["users"];
    }
}
