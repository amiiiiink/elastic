<?php

namespace Modules\ElasticLogger\Handlers;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;
use Illuminate\Support\Facades\Http;

class ElasticLogHandler extends AbstractProcessingHandler
{
    protected string $host;
    protected string $index;
    protected bool $enabled;

    public function __construct($level = Level::Error, bool $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->host = config('elasticlogger.host');
        $this->index = config('elasticlogger.index');
        $this->enabled = config('elasticlogger.enabled');
    }

    protected function write(LogRecord $record): void
    {
        if (! $this->enabled) return;

        try {
            Http::post("{$this->host}/{$this->index}/_doc", [
                'level' => $record->level->getName(),
                'message' => $record->message,
                'context' => $record->context,
                'extra' => $record->extra,
                'datetime' => $record->datetime->format('c'),
            ]);
        } catch (\Throwable $e) {
            // نادیده گرفتن خطاهای مربوط به ارسال به الستیک
        }
    }
}
