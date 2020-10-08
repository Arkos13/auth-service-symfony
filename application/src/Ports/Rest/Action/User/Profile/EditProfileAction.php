<?php

namespace App\Ports\Rest\Action\User\Profile;

use App\Application\Command\CommandBusInterface;
use App\Application\Command\User\Profile\Edit\EditUserProfileCommand;
use App\Ports\Rest\Action\BaseAction;
use App\Ports\Rest\Request\User\Profile\UserProfileEditRequest;
use Exception;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use App\Model\User\Entity\UserProfile;

class EditProfileAction extends BaseAction
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
     *     @SWG\Schema(type="object", ref=@Model(type=UserProfileEditRequest::class))
     *  ),
     * @SWG\Response(
     *     response=200,
     *     description="successful edited profile",
     *     @SWG\Schema(ref=@Model(type=UserProfile::class))
     * )
     * @Route("/api/users/profile", methods={"PUT"}, name="user_profile_edit")
     * @param UserProfileEditRequest $userProfileEditRequest
     * @return Response
     */
    public function __invoke(UserProfileEditRequest $userProfileEditRequest)
    {
        try {
            return $this->jsonResponse(
                $this->commandBus->handle(
                    new EditUserProfileCommand(
                        $this->getCurrentUser()->getId(),
                        $userProfileEditRequest->firstName,
                        $userProfileEditRequest->lastName,
                        $userProfileEditRequest->birthday,
                        $userProfileEditRequest->gender
                    )
                )
            );
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }
    }

}
