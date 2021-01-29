<?php

namespace App\Infrastructure\Shared\Persistence\DataFixtures\User;

use App\Model\Shared\Entity\Id;
use App\Model\User\Entity\Network;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class NetworkFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $arrayNetworks = [
            [
                "id" => "1eab6c19-0f9b-6a10-e604-ddb671d04e08",
                "user" => $this->getReference(UserFixtures::USER_TEST),
                "network" => "google",
                "identifier" => "123",
            ],
        ];
        foreach ($arrayNetworks as $key => $item) {
            $network = Network::create(
                Id::create($item["id"]),
                $item["user"],
                $item["identifier"],
                $item["network"]
            );
            $manager->persist($network);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 8;
    }

    public static function getGroups(): array
    {
        return ["users"];
    }
}
