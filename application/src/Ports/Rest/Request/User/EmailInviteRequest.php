<?php

namespace App\Ports\Rest\Request\User;

use App\Infrastructure\Http\RequestDtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

class EmailInviteRequest implements RequestDtoInterface
{
    /**
     * @Assert\NotBlank()
     * @SWG\Property(property="email", type="string")
     */
    public string $email;

    /**
     * @Assert\NotBlank()
     * @SWG\Property(property="url", description="url for confirmation account", type="string")
     */
    public string $url;

    public function __construct(Request $request)
    {
        $this->email = $request->request->get('email') ?? "";
        $this->url = $request->request->get('url') ?? "";
    }
}
