<?php

namespace App\Ports\Rest\Request\User;

use App\Infrastructure\Http\RequestDtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

class UserProfilePhoneEditRequest implements RequestDtoInterface
{
    /**
     * @Assert\NotBlank()
     * @SWG\Property(property="code", type="integer")
     */
    public int $code;

    public function __construct(Request $request)
    {
        $this->code = $request->request->get('code') ?? "";
    }
}
