<?php

namespace App\Ports\Rest\Request\User;

use App\Infrastructure\Http\RequestDtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

class PhoneConfirmCodeRequest implements RequestDtoInterface
{
    /**
     * @Assert\NotBlank()
     * @SWG\Property(property="phone", type="string")
     */
    public string $phone;

    public function __construct(Request $request)
    {
        $this->phone = $request->request->get('phone') ?? "";
    }
}
