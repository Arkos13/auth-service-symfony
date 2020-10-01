<?php

namespace App\Application\Service\User\Network\OAuth\Fetch;

use App\Model\User\Entity\Network;
use App\Model\User\Repository\NetworkRepositoryInterface;
use App\Application\Service\OAuth\Client\Registry\ClientRegistryInterface;
use League\OAuth2\Client\Token\AccessToken;

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

    /**
     * @param FetchUserData $data
     * @return Network|null
     */
    public function fetch($data): ?Network
    {
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
            $network->setAccessToken($data->accessToken);
            $this->networkRepository->add($network);
        }

        return $network;
    }
}
