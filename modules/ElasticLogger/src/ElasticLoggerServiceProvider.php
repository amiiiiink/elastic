<?php

namespace Modules\ElasticLogger;

use Illuminate\Support\ServiceProvider;
use Modules\ElasticLogger\Handlers\ElasticLogHandler;

class ElasticLoggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/elasticlogger.php', 'elasticlogger');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/elasticlogger.php' => config_path('elasticlogger.php'),
        ], 'config');

        $this->app['log']->getLogger()->pushHandler(
            new ElasticLogHandler()
        );
    }
}
