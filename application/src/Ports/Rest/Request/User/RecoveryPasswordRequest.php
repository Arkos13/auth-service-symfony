<?php

namespace App\Ports\Rest\Request\User;

use App\Infrastructure\Http\RequestDtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

class RecoveryPasswordRequest implements RequestDtoInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\EqualTo(propertyPath="confirmPassword")
     * @SWG\Property(property="password", type="string")
     */
    public string $password;

    /**
     * @Assert\NotBlank()
     * @SWG\Property(property="confirmPassword", type="string")
     */
    public string $confirmPassword;

    public function __construct(Request $request)
    {
        $this->password = $request->request->get('password') ?? "";
        $this->confirmPassword = $request->request->get('confirmPassword') ?? "";
    }
}
