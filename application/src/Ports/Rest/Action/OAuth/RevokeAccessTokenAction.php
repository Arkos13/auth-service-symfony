<?php

namespace App\Ports\Rest\Action\OAuth;

use App\Application\Command\CommandBusInterface;
use App\Application\Command\User\Oauth\AccessToken\Revoke\RevokeAccessTokenCommand;
use App\Ports\Rest\Action\BaseAction;
use Exception;
use Firebase\JWT\JWT;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use function preg_replace;
use function trim;

class RevokeAccessTokenAction extends BaseAction
{
    private CommandBusInterface $commandBus;

    public function __construct(SerializerInterface $serializer,
                                CommandBusInterface $commandBus)
    {
        parent::__construct($serializer);
        $this->commandBus = $commandBus;
    }

    /**
     * @SWG\Tag(name="OAuth")
     * @SWG\Response(
     *     response=200,
     *     description="successful revoke token",
     *     @SWG\Schema(type="boolean")
     * )
     * @Route("/api/token/revoke", methods={"POST"}, name="token_revoke")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        try {
            $this->commandBus->handle(
                new RevokeAccessTokenCommand(
                    $this->getIdAccessToken($request)
                )
            );

            return $this->jsonResponse(true);
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }
    }

    private function getIdAccessToken(Request $request): string
    {
        $authorization = $request->headers->get("authorization") ?? "";
        $token = trim((string) preg_replace('/^(?:\s+)?Bearer\s/', '', $authorization));

        $publicKey = file_get_contents($this->getParameter("public_key"));
        $key = openssl_pkey_get_public($publicKey ? $publicKey : "");
        $jwt = JWT::decode(
            $token,
            $key ? $key : "",
            array('RS256')
        );

        return ((array) $jwt)["jti"];
    }

}
