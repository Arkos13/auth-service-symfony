<?php

namespace App\Infrastructure\DataFixtures\User;

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
            $network = Network::create($item["user"], $item["identifier"], $item["network"], null, $item["id"]);
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
