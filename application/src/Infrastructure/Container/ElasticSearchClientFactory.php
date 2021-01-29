<?php

namespace App\Infrastructure\Container;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticSearchClientFactory
{
    public function create(string $esHost): Client
    {
        return ClientBuilder::create()->setHosts([$esHost])->build();
    }
}
