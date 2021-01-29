<?php

namespace App\Ports\Cli\Common;

use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Elasticsearch\Client;

class ESLogIndicesClearCommand extends Command
{
    private const COUNT_RELEVANT = 3;

    protected static $defaultName = "app:es:log-indices-clear";

    private Client $client;

    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("[".(new DateTime())->format('d.m.Y H:i:s')."] Start command app:es:log-indices-clear");

        $indices = $this->client->cat()->indices(["index" => "auth-logs-*", "s" => "index", "h" => ["index"]]);

        if (count($indices) === self::COUNT_RELEVANT) {
            return 0;
        }

        for ($i = 0; $i < (count($indices) - self::COUNT_RELEVANT); $i++) {
            $this->client->indices()->delete(["index" => $indices[$i]["index"]]);
        }

        $output->writeln("[".(new DateTime())->format('d.m.Y H:i:s')."] End command app:es:log-indices-clear");
        return 0;
    }
}
