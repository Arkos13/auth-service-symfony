<?php

namespace App\Ports\Rest\Action\User\Email;

use App\Application\Command\CommandBusInterface;
use App\Application\Command\User\Email\ConfirmUserByEmail\ConfirmUserByEmailCommand;
use App\Ports\Rest\Action\BaseAction;
use App\Ports\Rest\Request\User\ConfirmEmailRequest;
use Exception;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmEmailAction extends BaseAction
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
            $this->commandBus->handle(new ConfirmUserByEmailCommand($emailInviteRequest->token));
            return new JsonResponse(true);
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }
    }
}
