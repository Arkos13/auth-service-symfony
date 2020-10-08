<?php

namespace App\Ports\Rest\Action\User;

use App\Application\Query\QueryBusInterface;
use App\Application\Query\User\GetInfo\GetInfoUserQuery;
use App\Application\Query\User\DTO\UserDTO;
use App\Ports\Rest\Action\BaseAction;
use Exception;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class GetUserInfoAction extends BaseAction
{
    private QueryBusInterface $queryBus;

    public function __construct(SerializerInterface $serializer,
                                QueryBusInterface $queryBus)
    {
        parent::__construct($serializer);
        $this->queryBus = $queryBus;
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
                $this->queryBus->ask(
                    new GetInfoUserQuery($this->getCurrentUser()->getId())
                )
            );
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }
    }
}
