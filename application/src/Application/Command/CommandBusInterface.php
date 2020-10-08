<?php

namespace App\Application\Command;

interface CommandBusInterface
{
    /**
     * @param CommandInterface $command
     * @return mixed
     */
    public function handle(CommandInterface $command);
}
