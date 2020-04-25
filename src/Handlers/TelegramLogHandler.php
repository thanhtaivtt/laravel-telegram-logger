<?php
declare(strict_types=1);

namespace Thanhtaivtt\TelegramLogger\Handlers;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Thanhtaivtt\TelegramLogger\LoggerData;

/**
 * Handler send logs to Telegram using Telegram Bot API.
 *
 * How to use:
 *  1) Create telegram bot with https://telegram.me/BotFather
 *  2) Create a telegram channel where logs will be recorded.
 *  3) Add created bot from step 1 to the created channel from step 2.
 *
 * Use telegram bot API key from step 1 and channel name with '@' prefix from step 2 to create instance of TelegramBotHandler
 *
 * @link https://core.telegram.org/bots/api
 *
 * @author Thanhtaivtt <thanhtai96nd@gmail.com>
 */
class TelegramLogHandler extends AbstractProcessingHandler
{
    private const BOT_API = 'https://api.telegram.org/bot';

    /**
     * @var LoggerData
     */
    private $loggerData;

    /**
     * @var array
     */
    private $config = [];

    /**
     * TelegramLogHandler constructor.
     *
     * @param LoggerData $loggerData
     * @param array $config
     */
    public function __construct($loggerData, array $config)
    {
        parent::__construct($config['level'] ?? Logger::DEBUG, $config['bubble'] ?? true);
        $this->loggerData = $loggerData;
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    protected function write(array $record): void
    {
        if (empty($this->config['api_key']) || empty($this->config['chat_id'])) {
            throw new \RuntimeException('Please set up api_key or chat_id in config/logging.php');
        }

        if (($this->config['send_log'] ?? false)) {
            $this->send($this->messageBuilder($record['formatted']));
        }
    }

    /**
     * Build message.
     *
     * @param $rawMessage
     * @return string
     */
    protected function messageBuilder($rawMessage): string
    {
        $message = "<b>[Laravel Telegram Logger]</b> \r\n";
        $message .= "METHOD: <b>{$this->loggerData->requestMethod()}</b> \r\n";
        $message .= "URL:            {$this->loggerData->requestUrl()} \r\n";
        $message .= "IP:               {$this->loggerData->ipAddress()} \r\n";
        $message .= "<pre>{$rawMessage}</pre>";

        return  $message;
    }

    /**
     * Send request to @link https://api.telegram.org/bot on SendMessage action.
     *
     * @param string $message
     */
    protected function send(string $message): void
    {
        $ch = curl_init();
        $url = self::BOT_API . $this->config['api_key'] . '/SendMessage';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'text' => $message,
            'parse_mode' => 'HTML',
            'chat_id' => $this->config['chat_id'],
        ]));

        $result = curl_exec($ch);
        $result = json_decode($result, true);

        if ($result['ok'] === false) {
            throw new \RuntimeException('Telegram API error. Description: ' . $result['description']);
        }
    }
}
