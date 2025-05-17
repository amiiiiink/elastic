<?php
namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\ElasticsearchHandler;
use Monolog\Formatter\ElasticsearchFormatter;
use Elasticsearch\ClientBuilder;

class ElasticLogger
{
    public function __invoke(array $config)
    {
        $client = ClientBuilder::create()
            ->setHosts([env('ELASTIC_HOST', 'elasticsearch:9200')])
            ->build();

        $options = [
            'index' => env('ELASTIC_INDEX', 'laravel-logs'),
            'type'  => '_doc',
        ];

        $handler = new ElasticsearchHandler($client, $options);
        $handler->setFormatter(new ElasticsearchFormatter($options['index'], $options['type']));

        return new Logger('elasticsearch', [$handler]);
    }
}

