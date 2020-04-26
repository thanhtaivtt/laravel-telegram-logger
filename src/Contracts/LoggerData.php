<?php
declare(strict_types=1);

namespace Thanhtaivtt\TelegramLogger\Contracts;

interface LoggerData
{
    /**
     * Get the request URL.
     *
     * @return string
     */
    public function requestUrl(): ?string;

    /**
     * Get the request method.
     *
     * @return string|null
     */
    public function requestMethod(): ?string;

    /**
     * Check the error is raised on command.
     *
     * @return bool
     */
    public function isCommand(): bool;

    /**
     * Get the ip address.
     *
     * @return string|null
     */
    public function ipAddress(): ?string ;
}
