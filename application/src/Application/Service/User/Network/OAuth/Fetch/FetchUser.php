<?php

namespace App\Application\Service\User\Network\OAuth\Fetch;

use App\Model\User\Entity\Network;
use App\Model\User\Repository\NetworkRepositoryInterface;
use App\Application\Service\OAuth\Client\Registry\ClientRegistryInterface;
use League\OAuth2\Client\Token\AccessToken;
use Webmozart\Assert\Assert;

class FetchUser implements FetchUserInterface
{
    private ClientRegistryInterface $clientRegistry;
    private NetworkRepositoryInterface $networkRepository;

    public function __construct(ClientRegistryInterface $clientRegistry,
                                NetworkRepositoryInterface $networkRepository)
    {
        $this->clientRegistry = $clientRegistry;
        $this->networkRepository = $networkRepository;
    }

    public function fetch($data): ?Network
    {
        Assert::isInstanceOf($data, FetchUserData::class);

        $client = $this->clientRegistry->getClient($data->network);

        $user = $client->fetchUserFromToken(new AccessToken([
            "access_token" => $data->accessToken,
            "token_type" => "Bearer",
        ]));

        $network = $this->networkRepository->findOneByEmailAndNetwork(
            $user->toArray()["email"],
            $data->network
        );

        if ($network) {
            $this->networkRepository->updateAccessToken($network, $data->accessToken);
        }

        return $network;
    }
}
