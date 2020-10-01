<?php

namespace App\Ports\Rest\Request\User;

use App\Infrastructure\Http\RequestDtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

class RegistrationRequest implements RequestDtoInterface
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
     * @SWG\Property(property="url", description="url for confirmation account", type="string")
     */
    public string $url;

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
        $this->email = strtolower($request->request->get('email')) ?? "";
        $this->firstName = $request->request->get('firstName') ?? "";
        $this->lastName = $request->request->get('lastName') ?? "";
        $this->url = $request->request->get('url') ?? "";
        $this->password = $request->request->get('password') ?? "";
        $this->confirmPassword = $request->request->get('confirmPassword') ?? "";
    }
}
