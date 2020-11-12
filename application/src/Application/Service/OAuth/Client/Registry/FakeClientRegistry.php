<?php

namespace App\Application\Service\OAuth\Client\Registry;

use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FakeClientRegistry implements ClientRegistryInterface
{
    public function getClient(string $network): OAuth2ClientInterface
    {
        return new class implements OAuth2ClientInterface {

            public function setAsStateless(): void {}

            /**
             * @param array<mixed> $scopes
             * @param array<mixed> $options
             * @return RedirectResponse
             */
            public function redirect(array $scopes, array $options)
            {
                return new RedirectResponse('');
            }

            /**
             * @param array<mixed> $options
             * @return AccessToken
             */
            public function getAccessToken(array $options = []): AccessToken
            {
                return new AccessToken();
            }

            public function fetchUserFromToken(AccessToken $accessToken): ResourceOwnerInterface
            {
                if ($accessToken->getToken() === "exception") {
                    throw new IdentityProviderException("Invalid token", 0, []);
                }
                if ($accessToken->getToken() === "test") {
                    $array = ["email" => "test@gmail.com"];
                } else {
                    $array = ["email" => "test123@gmail.com"];
                }
                return new class($array) implements ResourceOwnerInterface {
                    /** @var array<mixed> */
                    public array $array;

                    /**
                     * @param array<mixed> $array
                     */
                    public function __construct(array $array)
                    {
                        $this->array = $array;
                    }

                    public function getId(): string
                    {
                        return "test";
                    }

                    /**
                     * @return array<mixed>
                     */
                    public function toArray()
                    {
                       return $this->array;
                    }
                };
            }

            public function fetchUser(): ResourceOwnerInterface
            {
                return new class implements ResourceOwnerInterface {

                    public function getId(): string
                    {
                        return "test";
                    }

                    /**
                     * @return string[]
                     */
                    public function toArray()
                    {
                        return ["email" => "test@gmail.com"];
                    }
                };
            }

            /**
             *  @psalm-suppress InvalidNullableReturnType
            */
            public function getOAuth2Provider(): ?AbstractProvider
            {
                return null;
            }
        };
    }
}
