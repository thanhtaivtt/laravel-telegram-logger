<?php
declare(strict_types=1);

namespace Thanhtaivtt\TelegramLogger;

use Monolog\Logger;
use Thanhtaivtt\TelegramLogger\Handlers\TelegramLogHandler;

class TelegramLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config): Logger
    {
        return new Logger(
            (string) config('app.name'),
            [new TelegramLogHandler(app(LoggerData::class), $config)]
        );
    }
}
