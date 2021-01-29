<?php

namespace App\Ports\Rest\Action\User\Password;

use App\Application\Command\CommandBusInterface;
use App\Application\Command\User\Password\SendInviteRecovery\SendInviteRecoveryPasswordCommand;
use App\Ports\Rest\Action\BaseAction;
use App\Ports\Rest\Request\User\EmailInviteRequest;
use Exception;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

class ResendEmailInviteRecoveryPasswordAction extends BaseAction
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
     *     @SWG\Schema(type="object", ref=@Model(type=EmailInviteRequest::class))
     *  )
     * @SWG\Response(
     *     response=200,
     *     description="successful resend email invite for recovery password",
     *     @SWG\Schema(type="boolean")
     * )
     * @Route("/open_api/users/resend_email_invite_recovery_password", methods={"POST"}, name="user_resend_email_invite_recovery_password")
     * @param EmailInviteRequest $emailInviteRequest
     * @return Response
     */
    public function __invoke(EmailInviteRequest $emailInviteRequest): Response
    {
        try {
            $this->commandBus->handle(
                new SendInviteRecoveryPasswordCommand(
                    $emailInviteRequest->email,
                    $emailInviteRequest->url
                )
            );
            return $this->jsonResponse(true);
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }
    }
}
