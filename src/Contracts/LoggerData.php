<?php
declare(strict_types=1);

namespace Thanhtaivtt\TelegramLogger\Contracts;

interface LoggerData
{
    /**
     * Get request URL.
     *
     * @return string
     */
    public function requestUrl(): ?string;

    /**
     * Get request method.
     *
     * @return string|null
     */
    public function requestMethod(): ?string;

    /**
     * Get ip address.
     *
     * @return string|null
     */
    public function ipAddress(): ?string ;
}
