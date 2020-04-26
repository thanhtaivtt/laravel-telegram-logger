<?php
declare(strict_types=1);

namespace Thanhtaivtt\TelegramLogger;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\URL;

class LoggerData implements \Thanhtaivtt\TelegramLogger\Contracts\LoggerData
{
    /**
     * Default request url
     */
    const DEFAULT_URL = 'undefined';

    /**
     * Default request method.
     */
    const DEFAULT_METHOD = 'command';

    /**
     * Default IP address
     */
    const DEFAULT_IP = '127.0.0.1';

    /**
     * Request raise error
     *
     * @var Request
     */
    private $request;

    /**
     * @var UrlGenerator
     */
    private $url;

    /**
     * LoggerData constructor.
     *
     * @param Request $request
     * @param UrlGenerator $url
     */
    public function __construct(Request $request, UrlGenerator $url)
    {
        $this->request = $request;
        $this->url = $url;
    }

    /**
     * @inheritDoc
     */
    public function requestUrl(): ?string
    {
        return $this->url->current() ?? self::DEFAULT_URL;
    }

    /**
     * @inheritDoc
     */
    public function requestMethod(): ?string
    {
        if ($this->isCommand()) {
            return self::DEFAULT_METHOD;
        }

        return $this->request->method();
    }

    /**
     * @inheritDoc
     */
    public function isCommand(): bool
    {
        return strpos(php_sapi_name(), 'cli') !== false;
    }

    /**
     * @inheritDoc
     */
    public function ipAddress(): ?string
    {
        return $this->request->server('HTTP_CF_CONNECTING_IP') ??
            $this->request->ip() ??
            self::DEFAULT_IP;
    }
}
