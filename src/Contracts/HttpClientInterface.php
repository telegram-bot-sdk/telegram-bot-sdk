<?php

namespace Telegram\Bot\Contracts;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface HttpClientInterface.
 */
interface HttpClientInterface
{
    public function getConfig(): array;

    public function setConfig(array $config);

    /**
     * Send HTTP request.
     *
     *
     * @return void|ResponseInterface
     */
    public function send(
        string $url,
        string $method,
        array $headers = [],
        array $options = [],
        bool $isAsyncRequest = false
    );
}
