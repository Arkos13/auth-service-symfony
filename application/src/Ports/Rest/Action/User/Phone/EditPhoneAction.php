<?php

namespace App\Ports\Rest\Action\User\Phone;

use App\Application\Command\User\Phone\Edit\EditPhoneCommand;
use App\Model\User\Entity\UserProfile;
use App\Model\User\Service\UserProfile\PhoneConfirmCode\CheckConfirmCodeInterface;
use App\Ports\Rest\Action\BaseAction;
use Exception;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Ports\Rest\Request\User\UserProfilePhoneEditRequest;

class EditPhoneAction extends BaseAction
{
    use HandleTrait;

    private CheckConfirmCodeInterface $checkConfirmCode;

    public function __construct(SerializerInterface $serializer,
                                CheckConfirmCodeInterface $checkConfirmCode,
                                MessageBusInterface $commandBus)
    {
        parent::__construct($serializer);
        $this->checkConfirmCode = $checkConfirmCode;
        $this->messageBus = $commandBus;
    }

    /**
     * @SWG\Tag(name="User")
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(type="object", ref=@Model(type=UserProfilePhoneEditRequest::class))
     *  ),
     * @SWG\Response(
     *     response=200,
     *     description="successful edit phone",
     *     @SWG\Schema(type="boolean")
     * )
     * @Route("/api/users/{id}/phones/edit", methods={"POST"}, name="user_phones_edit")
     * @param UserProfile $profile
     * @param UserProfilePhoneEditRequest $request
     * @return Response
     */
    public function __invoke(UserProfile $profile, UserProfilePhoneEditRequest $request)
    {
        try {
            $phone = $this->checkConfirmCode->checkCode($this->getCurrentUser(), $request->code);
            $this->handle(new EditPhoneCommand($profile->getUser()->getId(), $phone));
            return $this->jsonResponse(true);
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
