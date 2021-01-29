<?php

namespace App\Tests\Application\Command\User;

use App\Application\Command\User\Profile\Edit\EditUserProfileCommand;
use App\Infrastructure\Shared\Persistence\DataFixtures\User\UserFixtures;
use App\Model\User\Event\EditedUserProfileEvent;
use App\Tests\Application\ApplicationTestCase;

class EditUserProfileCommandHandlerTest extends ApplicationTestCase
{
    public function testSuccessfulEdit(): void
    {
        $command = new EditUserProfileCommand(
            UserFixtures::USER_ID_TEST,
            'test',
            'test',
            null,
            null
        );

        $this->handle($command);

        $this->assertEmmitSynchronizeEvent(EditedUserProfileEvent::class, "synchronize_profile");

    }


}