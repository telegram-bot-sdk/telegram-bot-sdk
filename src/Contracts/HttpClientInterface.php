<?php

namespace Telegram\Bot\Contracts;

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
     * @param string     $url
     * @param string     $method
     * @param array      $headers
     * @param array      $options
     * @param bool|false $isAsyncRequest
     *
     * @return mixed
     */
    public function send(
        string $url,
        string $method,
        array $headers = [],
        array $options = [],
        bool $isAsyncRequest = false
    );
}
