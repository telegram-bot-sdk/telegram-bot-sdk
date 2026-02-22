<?php

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\BotManager;
use Telegram\Bot\Contracts\HttpClientInterface;

/**
 * Creates a BotManager with an HTTP client mocked to return responses in sequence.
 *
 * @param  array|ResponseInterface|string|bool  $responses  Array of responses, or single response.
 *                                                          Each item can be:
 *                                                          - PSR-7 ResponseInterface instance,
 *                                                          - array|string (converted automatically to JSON body response),
 *                                                          - bool (to simulate simple successful or failed response).
 * @param  array  $config  Optional config overrides for BotManager.
 * @return BotManager Initialized BotManager with mocked HTTP client.
 */
function mockBotManagerWithResponses(array|ResponseInterface|string|bool $responses, array $config = []): BotManager
{
    if ($responses instanceof ResponseInterface) {
        $responsesQueue = [$responses];
    } elseif (is_array($responses) && array_key_exists('ok', $responses)) {
        $responsesQueue = [$responses];
    } elseif (! is_array($responses)) {
        // In case $responses is scalar or other
        $responsesQueue = [$responses];
    } else {
        $responsesQueue = $responses;
    }

    // Then continue using $responsesQueue below.
    $httpClient = Mockery::mock(HttpClientInterface::class);
    // Convert all items to ResponseInterface if not already
    $responsesQueue = array_map(function ($item) {
        if ($item instanceof ResponseInterface) {
            return $item;
        }

        if (is_bool($item)) {
            // Represent boolean as simple JSON string for response body { "ok": true/false }
            return new Response(200,
                ['Content-Type' => 'application/json'],
                json_encode(['ok' => $item, 'result' => $item]));
        }

        if (is_array($item) || is_string($item)) {
            // Convert arrays or strings to JSON responses
            return new Response(200, ['Content-Type' => 'application/json'], json_encode($item));
        }

        throw new InvalidArgumentException('Unsupported response item for HTTP client mock');
    }, $responsesQueue);

    $httpClient->shouldReceive('send')
        ->andReturnUsing(function ($request) use (&$responsesQueue) {
            if (empty($responsesQueue)) {
                throw new RuntimeException('No more fake HTTP responses in queue.');
            }

            // Shift and return next queued response
            return array_shift($responsesQueue);
        });

    // Base config for BotManager with fallback token and API URL
    $defaultConfig = [
        'use' => 'default',
        'bots' => [
            'default' => [
                'token' => 'your-fake-bot-token',
            ],
        ],
        'http' => [
            'api_url' => 'https://api.telegram.org',
        ],
    ];

    $config = array_merge_recursive($defaultConfig, $config);

    $botManager = new BotManager($config);
    $botManager->setHttpClientHandler($httpClient);

    return $botManager;
}
