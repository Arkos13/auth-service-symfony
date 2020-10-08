<?php

namespace App\Ports\Rest\Action\User;

use App\Application\Command\CommandBusInterface;
use App\Application\Command\User\Registration\RegistrationUserCommand;
use App\Ports\Rest\Action\BaseAction;
use Exception;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use App\Ports\Rest\Request\User\RegistrationRequest;

class RegistrationAction extends BaseAction
{
    private CommandBusInterface $commandBus;

    public function __construct(SerializerInterface $serializer,
                                CommandBusInterface $commandBus)
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
     *     @SWG\Schema(type="object", ref=@Model(type=RegistrationRequest::class))
     *  ),
     * @SWG\Response(
     *     response=200,
     *     description="successful registration",
     *     @SWG\Schema(type="boolean")
     * )
     * @Route("/open_api/users/registration", methods={"POST"}, name="user_registration")
     * @param RegistrationRequest $registrationRequest
     * @return Response
     */
    public function __invoke(RegistrationRequest $registrationRequest)
    {
        try {
            return $this->jsonResponse(
                $this->commandBus->handle(
                    new RegistrationUserCommand(
                        $registrationRequest->email,
                        $registrationRequest->firstName,
                        $registrationRequest->lastName,
                        $registrationRequest->url,
                        $registrationRequest->password
                    )
                )
            );
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }
    }

}
