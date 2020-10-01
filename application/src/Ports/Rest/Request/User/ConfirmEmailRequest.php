<?php

namespace App\Ports\Rest\Request\User;

use App\Infrastructure\Http\RequestDtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

class ConfirmEmailRequest implements RequestDtoInterface
{
    /**
     * @Assert\NotBlank()
     * @SWG\Property(property="token", type="string")
     */
    public string $token;

    public function __construct(Request $request)
    {
        $this->token = $request->request->get('token') ?? "";
    }
}
