<?php

namespace Telegram\Bot\Contracts;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Promise\PromiseInterface;

interface HttpClientInterface
{
    public function getConfig(): array;

    public function setConfig(array $config);

    public function send(
        string $url,
        string $method,
        array $headers = [],
        array $options = [],
        bool $isAsyncRequest = false
    ): ResponseInterface|PromiseInterface;
}
