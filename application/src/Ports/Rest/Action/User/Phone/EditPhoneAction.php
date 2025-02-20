<?php

namespace App\Ports\Rest\Action\User\Phone;

use App\Application\Command\CommandBusInterface;
use App\Application\Command\User\Phone\Edit\EditPhoneCommand;
use App\Model\User\Entity\UserProfile;
use App\Application\Service\User\Phone\CheckConfirmCodeInterface;
use App\Ports\Rest\Action\BaseAction;
use Exception;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Ports\Rest\Request\User\UserProfilePhoneEditRequest;

class EditPhoneAction extends BaseAction
{
    private CheckConfirmCodeInterface $checkConfirmCode;
    private CommandBusInterface $commandBus;

    public function __construct(SerializerInterface $serializer,
                                CheckConfirmCodeInterface $checkConfirmCode,
                                CommandBusInterface $commandBus)
    {
        parent::__construct($serializer);
        $this->checkConfirmCode = $checkConfirmCode;
        $this->commandBus = $commandBus;
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
    public function __invoke(UserProfile $profile, UserProfilePhoneEditRequest $request): Response
    {
        try {
            $phone = $this->checkConfirmCode->checkCode($this->getCurrentUser()->getId(), $request->code);
            $this->commandBus->handle(new EditPhoneCommand($profile->getUserId(), $phone));
            return $this->jsonResponse(true);
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
