<?php

namespace App\Ports\Rest\Action\User\Password;

use App\Application\Command\User\Password\Recovery\RecoveryPasswordCommand;
use App\Ports\Rest\Action\BaseAction;
use App\Ports\Rest\Request\User\RecoveryPasswordRequest;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

class RecoveryPasswordAction extends BaseAction
{
    use HandleTrait;

    public function __construct(SerializerInterface $serializer, MessageBusInterface $commandBus)
    {
        parent::__construct($serializer);
        $this->messageBus = $commandBus;
    }

    /**
     * @SWG\Tag(name="User")
     * @SWG\Parameter(name="token", description="confirm token", in="query", type="string", required=true)
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(type="object", ref=@Model(type=RecoveryPasswordRequest::class))
     *  )
     * @SWG\Response(
     *     response=200,
     *     description="successful recovery password",
     *     @SWG\Schema(type="boolean")
     * )
     * @Route("/open_api/users/recovery_password", methods={"POST"}, name="user_recovery_password")
     * @param RecoveryPasswordRequest $recoveryPasswordRequest
     * @param Request $request
     * @return Response
     */
    public function __invoke(RecoveryPasswordRequest $recoveryPasswordRequest, Request $request)
    {
        try {
            $this->handle(
                new RecoveryPasswordCommand(
                    $request->query->get("token"),
                    $recoveryPasswordRequest->password
                )
            );
            return $this->jsonResponse(true);
        } catch (HandlerFailedException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }
    }

}
