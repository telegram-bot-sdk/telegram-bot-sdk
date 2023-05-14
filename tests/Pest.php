<?php

use Telegram\Bot\Bot;
use Telegram\Bot\BotManager;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Contracts\HttpClientInterface;
use GuzzleHttp\Psr7\Response;

function mockBotManager(array|string|ResponseInterface|PromiseInterface $response, array $config = []): BotManager
{
    $httpClient = Mockery::mock(HttpClientInterface::class);

    if(! $response instanceof ResponseInterface || ! $response instanceof PromiseInterface) {
        $response = new Response(
            body: json_encode($response),
        );
    }

    $httpClient->shouldReceive('send')
        ->once()
        ->andReturn($response);

    $config = [
        'use'  => 'default',
        'bots' => [
            'default' => [
                'token' => 'your-bot-token',
            ],
        ],
        'http' => [
            'api_url' => 'https://api.telegram.org',
        ],
        ... $config,
    ];

    $botManager = new BotManager($config);
    $botManager->setHttpClientHandler($httpClient);

    return $botManager;
}

function mockBotWithResult(array $result, bool $isOkResult = true, array $config = []): Bot
{
    return mockBotManager(resultPayload($result, $isOkResult), $config)->bot();
}

function resultPayload(array|string|bool $result, bool $ok = true): array
{
    return [
        'ok' => $ok,
        'result' => $result,
    ];
}
