<?php

namespace App\Ports\Rest\Action\OAuth\Network;

use App\Application\Command\User\RegistrationViaNetwork\RegistrationViaNetworkCommand;
use App\Ports\Rest\Action\BaseAction;
use App\Ports\Rest\Request\User\UserNetworkCheckRequest;
use App\Application\Service\User\Network\OAuth\Fetch\FetchUserData;
use App\Application\Service\User\Network\OAuth\Fetch\FetchUserInterface;
use Exception;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Trikoder\Bundle\OAuth2Bundle\Controller\TokenController as TrikoderTokenController;

class ConnectAction extends BaseAction
{
    use HandleTrait;

    private FetchUserInterface $fetchUser;
    private TrikoderTokenController $tokenController;
    private RequestStack $requestStack;

    public function __construct(SerializerInterface $serializer,
                                FetchUserInterface $fetchUser,
                                TrikoderTokenController $tokenController,
                                RequestStack $requestStack,
                                MessageBusInterface $commandBus)
    {
        parent::__construct($serializer);
        $this->fetchUser = $fetchUser;
        $this->tokenController = $tokenController;
        $this->requestStack = $requestStack;
        $this->messageBus = $commandBus;
    }

    /**
     * @SWG\Tag(name="OAuth")
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(type="object", ref=@Model(type=UserNetworkCheckRequest::class))
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
     * @Route("/open_api/networks/connect", methods={"POST"}, name="networks_facebook_check")
     * @param UserNetworkCheckRequest $request
     * @param ServerRequestInterface $serverRequest
     * @param ResponseFactoryInterface $responseFactory
     * @return ResponseInterface
     */
    public function __invoke(UserNetworkCheckRequest $request,
                                  ServerRequestInterface $serverRequest,
                                  ResponseFactoryInterface $responseFactory)
    {
        try {
            $network = $this->fetchUser->fetch(
                new FetchUserData($request->email, $request->provider, $request->networkAccessToken)
            );

            if (!$network) {
                $this->handle(
                    new RegistrationViaNetworkCommand(
                        $request->email,
                        $request->firstName,
                        $request->lastName,
                        $request->provider,
                        $request->id,
                        $request->networkAccessToken
                    )
                );
            }
            $serverRequest = $serverRequest->withParsedBody([
                "grant_type" => "password",
                "username" => $request->email,
                "password" => "",
                "client_id" => $request->client_id,
                "client_secret" => $request->client_secret
            ]);
            return $this->tokenController->indexAction($serverRequest, $responseFactory);
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }
    }

}
