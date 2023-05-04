<?php

namespace Telegram\Bot\Contracts;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

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
