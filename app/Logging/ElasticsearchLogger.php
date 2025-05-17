<?php
namespace App\Logging;

use Elastic\Elasticsearch\ClientBuilder;
use Monolog\Handler\ElasticsearchHandler;
use Monolog\Logger;
use Monolog\Formatter\ElasticsearchFormatter;

class ElasticsearchLogger
{
    public function __invoke(array $config)
    {
        $client = ClientBuilder::create()
            ->setHosts(['http://elasticsearch:9200']) // چون توی Docker با این اسم بالا اومده
            ->build();

        $handler = new ElasticsearchHandler($client, [
            'index' => 'laravel-logs-' . date('Y.m.d'),
            'type' => '_doc',
        ]);

        $handler->setFormatter(new ElasticsearchFormatter('laravel-logs-' . date('Y.m.d'), '_doc'));

        return new Logger('elasticsearch', [$handler]);
    }
}

