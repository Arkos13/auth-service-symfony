<?php

namespace App\Infrastructure\Shared\Persistence\DataFixtures\OAuth2;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Trikoder\Bundle\OAuth2Bundle\Model\Client;
use Trikoder\Bundle\OAuth2Bundle\Model\Grant;
use Trikoder\Bundle\OAuth2Bundle\Model\RedirectUri;

class ClientFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface
{
    public const CLIENT_TEST = 'client-test';

    public function load(ObjectManager $manager)
    {
        $clientData =  [
            "identifier" => "61bba35dbf85fcb8cf07f8c80209fbf5",
            "secret" => "5fdf5f673438aae9c92b5e567e81ffeb80d78a9e696c4d1915f41c621cad418b379b5e156912f5114c3f76811f94093d62f24bb9ba05b78073ac3ed258755e9e",
            "grants" => [new Grant("password"), new Grant("refresh_token")],
            "active" => true,
            "redirectUris" => new RedirectUri("http://test")
        ];
        $client = new Client($clientData["identifier"], $clientData["secret"]);
        $client->setGrants(...$clientData["grants"]);
        $client->setActive($clientData["active"]);
        $client->setRedirectUris($clientData["redirectUris"]);
        $manager->persist($client);
        $manager->flush();
        $this->addReference(self::CLIENT_TEST, $client);
    }

    public function getOrder()
    {
        return 1;
    }

    public static function getGroups(): array
    {
        return ["users"];
    }
}
