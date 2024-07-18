<?php

namespace App\Modules\Infrastructure;

use Logtail\Monolog\LogtailHandler;
use Logtail\Monolog\LogtailHandlerBuilder;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;

class BetterStackHandler extends AbstractProcessingHandler
{
    private LogtailHandler $logtailHandler;

    public function __construct(string $sourceToken, $level = Logger::DEBUG, bool $bubble = true)
    {
        $this->logtailHandler = LogtailHandlerBuilder::withSourceToken($sourceToken)
            ->withBufferLimit(100)
            ->withFlushIntervalMilliseconds(500)
            ->withExceptionThrowing(true)
            ->build();

        $this->logtailHandler->pushProcessor(new PsrLogMessageProcessor());

        parent::__construct($level, $bubble);
    }

    protected function write(array $record): void
    {
        $this->logtailHandler->handle($record);
    }
}
