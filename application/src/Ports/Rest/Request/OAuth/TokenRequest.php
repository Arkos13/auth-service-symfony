<?php

namespace App\Ports\Rest\Request\OAuth;

use App\Infrastructure\Http\RequestDtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

class TokenRequest implements RequestDtoInterface
{
    /**
     * @Assert\NotBlank()
     * @SWG\Property(property="grant_type", description="refresh_token or password", type="string")
    */
    public string $grant_type;

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

    /**
     * @SWG\Property(property="scope", description="What scopes are requested, for all, use '*'", type="string")
     */
    public ?string $scope;

    /**
     * @SWG\Property(property="refresh_token", description="Refresh_token from the authorization response", type="string")
     */
    public ?string $refresh_token;

    /**
     * @SWG\Property(property="username", description="Username for login", type="string")
     */
    public ?string $username;

    /**
     * @SWG\Property(property="password", description="Password for the user", type="string")
     */
    public ?string $password;

    public function __construct(Request $request)
    {
        $this->grant_type = $request->request->get("grant_type") ?? "";
        $this->client_id = $request->request->get("client_id") ?? "";
        $this->client_secret = $request->request->get("client_secret") ?? "";
        $this->scope = $request->request->get("scope");
        $this->refresh_token = $request->request->get("refresh_token");
        $this->username = $request->request->get("username");
        $this->password = $request->request->get("password");
    }
}
