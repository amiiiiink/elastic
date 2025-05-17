<?php

return [
    'enabled' => env('ELASTIC_ENABLED', true),
    'host' => env('ELASTIC_HOST', 'http://localhost:9200'),
    'index' => env('ELASTIC_INDEX', 'laravel-logs'),
];
