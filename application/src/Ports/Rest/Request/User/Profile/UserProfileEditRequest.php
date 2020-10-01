<?php

namespace App\Ports\Rest\Request\User\Profile;

use App\Infrastructure\Http\RequestDtoInterface;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

class UserProfileEditRequest implements RequestDtoInterface
{
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
     * @SWG\Property(property="birthday", type="string")
     */
    public ?DateTimeImmutable $birthday;

    /**
     * @Assert\Choice(callback={"App\Model\User\Entity\UserProfile", "getGenderValues"})
     * @SWG\Property(property="gender", type="string")
     */
    public ?string $gender;

    public function __construct(Request $request)
    {
        $this->firstName = $request->request->get('firstName') ?? "";
        $this->lastName = $request->request->get('lastName') ?? "";
        $this->birthday = $request->request->get('birthday')
            ? new DateTimeImmutable($request->request->get('birthday'))
            : null;
        $this->gender = $request->request->get('gender');
    }
}
