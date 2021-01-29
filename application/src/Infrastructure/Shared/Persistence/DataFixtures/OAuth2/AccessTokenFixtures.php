<?php

namespace App\Infrastructure\Shared\Persistence\DataFixtures\OAuth2;

use App\Infrastructure\Shared\Persistence\DataFixtures\User\UserFixtures;
use App\Model\User\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Trikoder\Bundle\OAuth2Bundle\Model\AccessToken;

class AccessTokenFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        /** @var User $user */
        $user = $this->getReference(UserFixtures::USER_TEST);
        $arrayAccessTokens = [
            [
//                "identifier" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI2MWJiYTM1ZGJmODVmY2I4Y2YwN2Y4YzgwMjA5ZmJmNSIsImp0aSI6Ijc4MzVjZTM5OTcwNTQxMzZiYzBhMTg5MjRiOTc1M2ViYWZiZWM3MDY2MmYyOGZjY2Q1YmFhNTllZGRmYjk1ODExOTVkMmI3YmYxZmQ5MzMwIiwiaWF0IjoxNTg5ODExMjY4LCJuYmYiOjE1ODk4MTEyNjgsImV4cCI6MTYyMTM0NzI2Nywic3ViIjoidGVzdEBnbWFpbC5jb20iLCJzY29wZXMiOltdfQ.TnBOGheoF4XrLhW8g3xH0Mmcmuz2ownj8nmAJFJM0to2niVgLzpjEMgF7IzZMFxxaYomTzivVUkGBR-TpfIaxtBjT0lSgnSNXIOu8Gh9aWMkJyq3ELV1SsndqOJKgBfYaAgUoiekj0QZ-z1hI-rwSrA_RafmYRgDYS2lt0uuOxTxtpJsIZzjiQR4bjE_YPHW0Xtfge-Row32stExpxBqqf9jzMhfiz5pisQutfHcFXMC31uMDVRSMkBUnyQARZPUbFI5-1U5nKuOgB7sug_CGFuK4hiWTCBt9k4H_VjvgWcx7zvv0_srtauj040Bhihyf6GHhNmtJxzudxb9-2Q9dQ",
                "identifier" => "7835ce3997054136bc0a18924b9753ebafbec70662f28fccd5baa59eddfb9581195d2b7bf1fd9330",
                "expire" => (new DateTimeImmutable())->setTimestamp(1621347267),
                "client" => $this->getReference(ClientFixtures::CLIENT_TEST),
                "userIdentifier" => $user->email,
                "scopes" => []
            ]
        ];
        foreach ($arrayAccessTokens as $item) {
            $token = new AccessToken(
                $item["identifier"],
                $item["expire"],
                $item["client"],
                $item["userIdentifier"],
                $item["scopes"],
            );
            $manager->persist($token);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 6;
    }

    public static function getGroups(): array
    {
        return ["users"];
    }
}
