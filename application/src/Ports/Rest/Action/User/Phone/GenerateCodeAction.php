<?php

namespace App\Ports\Rest\Action\User\Phone;

use App\Application\Command\CommandBusInterface;
use App\Application\Command\User\Phone\ConfirmCode\Generate\GeneratePhoneConfirmCodeCommand;
use App\Infrastructure\User\Security\Voter\UserProfileVoter;
use App\Ports\Rest\Action\BaseAction;
use Exception;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Ports\Rest\Request\User\PhoneConfirmCodeRequest;

class GenerateCodeAction extends BaseAction
{
    private CommandBusInterface $commandBus;

    public function __construct(SerializerInterface $serializer, CommandBusInterface $commandBus)
    {
        parent::__construct($serializer);
        $this->commandBus = $commandBus;
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
    public function __invoke(PhoneConfirmCodeRequest $request): Response
    {
        $this->denyAccessUnlessGranted(UserProfileVoter::EDIT_PHONE, $request->phone);

        try {
            $this->commandBus->handle(
                new GeneratePhoneConfirmCodeCommand(
                    $this->getCurrentUser()->getId(),
                    $request->phone
                )
            );
            return $this->jsonResponse(true);
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }
    }

}
