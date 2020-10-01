<?php

namespace App\Ports\Rest\Request\User;

use App\Infrastructure\Http\RequestDtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

class UserNetworkCheckRequest implements RequestDtoInterface
{
    /**
     * @Assert\NotBlank()
     * @SWG\Property(property="email", type="string")
     */
    public string $email;

    /**
     * @Assert\NotBlank()
     * @SWG\Property(property="firstName", type="string")
     */
    public string $firstName;

    /**
     * @Assert\NotBlank()
     * @SWG\Property(property="lastName", type="string")
     */
    public string $lastName;

    /**
     * @Assert\NotBlank()
     * @SWG\Property(property="id", type="string")
     */
    public string $id;

    /**
     * @Assert\NotBlank()
     * @SWG\Property(property="networkAccessToken", type="string")
     */
    public string $networkAccessToken;

    /**
     * @Assert\Choice(callback={"App\Model\User\Entity\Network", "getNetworks"})
     * @SWG\Property(property="provider", type="string")
     */
    public string $provider;

    /**
     * @Assert\NotBlank()
     * @SWG\Property(property="client_id", description="OAuth Client ID", type="string")
     */
    public string $client_id;

    /**
     * @Assert\NotBlank()
     * @SWG\Property(property="client_secret", description="OAuth Client Secret", type="string")
     */
    public string $client_secret;

    public function __construct(Request $request)
    {
        $this->email = $request->request->get('email') ?? "";
        $this->firstName = $request->request->get('firstName') ?? "";
        $this->lastName = $request->request->get('lastName') ?? "";
        $this->id = $request->request->get('id') ?? "";
        $this->networkAccessToken = $request->request->get('networkAccessToken') ?? "";
        $this->provider = $request->request->get('provider') ?? "";
        $this->client_id = $request->request->get('client_id') ?? "";
        $this->client_secret = $request->request->get('client_secret') ?? "";
    }
}
