<?php

namespace App\Ports\Rest\Action\User;

use App\Application\Command\User\Confirm\ConfirmUserCommand;
use App\Ports\Rest\Action\BaseAction;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

class UserConfirmAction extends BaseAction
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
     * @SWG\Response(
     *     response=200,
     *     description="successful confirm user",
     *     @SWG\Schema(type="boolean")
     * )
     * @Route("/open_api/users/confirm", methods={"POST"}, name="user_confirm")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        try {
            $this->handle(
                new ConfirmUserCommand(
                    $request->query->get("token")
                )
            );
            return $this->jsonResponse(true);
        } catch (HandlerFailedException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }
    }

}
