<?php

namespace App\Ports\Rest\Action\User\Email;

use App\Application\Command\User\Email\SendChangeInvite\SendChangeInviteCommand;
use App\Ports\Rest\Action\BaseAction;
use App\Ports\Rest\Request\User\EmailInviteRequest;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Swagger\Annotations as SWG;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class SendChangeEmailInviteAction extends BaseAction
{
    use HandleTrait;

    public function __construct(SerializerInterface $serializer,
                                MessageBusInterface $commandBus)
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
     *     @SWG\Schema(type="object", ref=@Model(type=EmailInviteRequest::class))
     *  ),
     * @SWG\Response(
     *     response=200,
     *     description="successful send invite",
     *     @SWG\Schema(type="boolean")
     * )
     * @Route("/api/users/email/send_change_email_invite", methods={"POST"}, name="user_send_change_email_invite")
     * @param EmailInviteRequest $emailInviteRequest
     * @return Response
     */
    public function __invoke(EmailInviteRequest $emailInviteRequest)
    {
        try {
            $this->handle(
                new SendChangeInviteCommand(
                    $this->getCurrentUser()->getEmail(),
                    $emailInviteRequest->email,
                    $emailInviteRequest->url,
                )
            );
            return $this->jsonResponse(true);
        } catch (HandlerFailedException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }
    }
}
