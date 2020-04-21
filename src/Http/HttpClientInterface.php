<?php

namespace Telegram\Bot\Http;

/**
 * Interface HttpClientInterface.
 */
interface HttpClientInterface
{
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

    /**
     * Get Timeout.
     *
     * @return int
     */
    public function getTimeOut(): int;

    /**
     * Set Timeout.
     *
     * @param int $timeOut
     *
     * @return $this
     */
    public function setTimeOut(int $timeOut): self;

    /**
     * Get Connection Timeout.
     *
     * @return int
     */
    public function getConnectTimeOut(): int;

    /**
     * Set Connection Timeout.
     *
     * @param int $connectTimeOut
     *
     * @return $this
     */
    public function setConnectTimeOut(int $connectTimeOut): self;
}
