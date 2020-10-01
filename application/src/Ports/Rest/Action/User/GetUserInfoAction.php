<?php

namespace App\Ports\Rest\Action\User;

use App\Application\Query\User\GetInfo\GetInfoUserQuery;
use App\Application\Query\User\DTO\UserDTO;
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

class GetUserInfoAction extends BaseAction
{
    use HandleTrait;

    public function __construct(SerializerInterface $serializer,
                                MessageBusInterface $queryBus)
    {
        parent::__construct($serializer);
        $this->messageBus = $queryBus;
    }

    /**
     * @SWG\Tag(name="User")
     * @SWG\Response(
     *     response=200,
     *     description="successful send info of user",
     *     @SWG\Schema(type="object", ref=@Model(type=UserDTO::class))
     * )
     * @Route("/api/users/info", methods={"GET"}, name="user_info")
     * @return Response
     */
    public function __invoke()
    {
        try {
            return $this->jsonResponse(
                $this->handle(
                    new GetInfoUserQuery($this->getCurrentUser()->getId())
                )
            );
        } catch (HandlerFailedException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }
    }
}
