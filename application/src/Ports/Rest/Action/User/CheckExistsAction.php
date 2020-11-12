<?php

namespace App\Ports\Rest\Action\User;

use App\Application\Query\QueryBusInterface;
use App\Application\Query\User\GetInfoByEmail\GetInfoUserByEmailQuery;
use App\Application\Query\User\DTO\UserDTO;
use App\Ports\Rest\Action\BaseAction;
use Exception;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

class CheckExistsAction extends BaseAction
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
     * @SWG\Parameter(name="email", in="query", type="string", required=true),
     * @SWG\Response(
     *     response=200,
     *     description="successful find user",
     *     @SWG\Schema(ref=@Model(type=UserDTO::class))
     * )
     * @Route("/open_api/users/check_exists", methods={"GET"}, name="user_check_exists")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        if(!($email = $request->query->get('email'))) {
            throw new BadRequestHttpException('Email is not specified');
        }

        try {
            return $this->jsonResponse(
                $this->queryBus->ask(
                    new GetInfoUserByEmailQuery(
                        $email
                    )
                )
            );
        } catch (Exception $e) {
            return $this->jsonResponse(false);
        }
    }
}
