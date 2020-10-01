<?php

namespace App\Ports\Rest\Action\User\Phone;

use App\Application\Command\User\Phone\ConfirmCode\Generate\GeneratePhoneConfirmCodeCommand;
use App\Infrastructure\Security\Voter\User\Profile\UserProfileVoter;
use App\Ports\Rest\Action\BaseAction;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Ports\Rest\Request\User\PhoneConfirmCodeRequest;

class GenerateCodeAction extends BaseAction
{
    use HandleTrait;

    public function __construct(SerializerInterface $serializer, MessageBusInterface $commandBus)
    {
        parent::__construct($serializer);
        $this->messageBus = $commandBus;
    }

    /**
     * @SWG\Tag(name="User")
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(type="object", ref=@Model(type=PhoneConfirmCodeRequest::class))
     *  ),
     * @SWG\Response(
     *     response=200,
     *     description="successful generated code",
     *     @SWG\Schema(type="boolean")
     * )
     * @Route("/api/users/phones/generate_confirm_code", methods={"POST"}, name="user_phones_generate_confirm_code")
     * @param PhoneConfirmCodeRequest $request
     * @return Response
     */
    public function __invoke(PhoneConfirmCodeRequest $request)
    {
        $this->denyAccessUnlessGranted(UserProfileVoter::EDIT_PHONE, $request->phone);

        try {
            $this->handle(
                new GeneratePhoneConfirmCodeCommand(
                    $this->getCurrentUser()->getId(),
                    $request->phone
                )
            );
            return $this->jsonResponse(true);
        } catch (HandlerFailedException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }
    }

}
