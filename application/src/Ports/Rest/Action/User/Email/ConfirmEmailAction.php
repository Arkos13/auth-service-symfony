<?php

namespace App\Ports\Rest\Action\User\Email;

use App\Application\Command\User\Email\ConfirmUserByEmail\ConfirmUserByEmailCommand;
use App\Ports\Rest\Action\BaseAction;
use App\Ports\Rest\Request\User\ConfirmEmailRequest;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmEmailAction extends BaseAction
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
     *     @SWG\Schema(type="object", ref=@Model(type=ConfirmEmailRequest::class))
     *  ),
     * @SWG\Response(
     *     response=200,
     *     description="successful confirm email",
     *     @SWG\Schema(type="boolean")
     * )
     * @Route("/open_api/users/email/confirm", methods={"POST"}, name="user_email_confirm")
     * @param ConfirmEmailRequest $emailInviteRequest
     * @return JsonResponse
     */
    public function __invoke(ConfirmEmailRequest $emailInviteRequest)
    {
        try {
            $this->handle(new ConfirmUserByEmailCommand($emailInviteRequest->token));
            return new JsonResponse(true);
        } catch (HandlerFailedException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }
    }
}
