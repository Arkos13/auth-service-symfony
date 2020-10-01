<?php

namespace App\Ports\Rest\Action\OAuth;

use App\Ports\Rest\Action\BaseAction;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Trikoder\Bundle\OAuth2Bundle\Controller\TokenController as TrikoderTokenController;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use App\Ports\Rest\Request\OAuth\TokenRequest;

class GetTokenAction extends BaseAction
{
    private TrikoderTokenController $tokenController;

    public function __construct(SerializerInterface $serializer,
                                TrikoderTokenController $tokenController)
    {
        parent::__construct($serializer);
        $this->tokenController = $tokenController;
    }

    /**
     * @SWG\Tag(name="OAuth")
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(type="object", ref=@Model(type=TokenRequest::class))
     *  ),
     * @SWG\Response(
     *     response=200,
     *     description="Get token",
     *     @SWG\Schema(
     *          @SWG\Property(property="token_type", type="string"),
     *          @SWG\Property(property="expires_in", type="integer"),
     *          @SWG\Property(property="access_token", type="string"),
     *          @SWG\Property(property="refresh_token", type="string"),
     *     )
     * )
     * @Route("/open_api/token", methods={"POST"}, name="oauth_token")
     * @param ServerRequestInterface $serverRequest
     * @param ResponseFactoryInterface $responseFactory
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $serverRequest, ResponseFactoryInterface $responseFactory)
    {
        return $this->tokenController->indexAction($serverRequest, $responseFactory);
    }
}
