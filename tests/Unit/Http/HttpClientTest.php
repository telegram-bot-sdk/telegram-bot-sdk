<?php

use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Contracts\HttpClientInterface;

it('can get the configuration', function () {
    $httpClient = Mockery::mock(HttpClientInterface::class);
    $config = ['key' => 'value'];

    $httpClient->shouldReceive('getConfig')->andReturn($config);

    expect($httpClient->getConfig())->toBe($config);
});

it('can set the configuration', function () {
    $httpClient = Mockery::mock(HttpClientInterface::class);
    $config = ['key' => 'value'];

    $httpClient->shouldReceive('setConfig')
        ->once()
        ->with($config);

    $httpClient->setConfig($config);
});

it('can send a synchronous request', function () {
    $httpClient = Mockery::mock(HttpClientInterface::class);
    $url = 'https://api.telegram.org';
    $method = 'POST';
    $headers = ['Content-Type' => 'application/json'];
    $options = ['timeout' => 30];

    $response = new Response(
        body: json_encode(['ok' => true, 'result' => []]),
    );

    $httpClient->shouldReceive('send')
        ->with($url, $method, $headers, $options, false)
        ->andReturn($response);

    /** @var ResponseInterface $result */
    $result = $httpClient->send($url, $method, $headers, $options, false);

    expect($result)->toBe($response);
});

it('can send an asynchronous request', function () {
    $promise = Mockery::mock(PromiseInterface::class);
    $httpClient = Mockery::mock(HttpClientInterface::class);
    $url = 'https://api.telegram.org';
    $method = 'GET';
    $headers = ['Content-Type' => 'application/json'];
    $options = ['timeout' => 30];

    $httpClient->shouldReceive('send')
        ->with($url, $method, $headers, $options, true)
        ->andReturn($promise);

    $result = $httpClient->send($url, $method, $headers, $options, true);

    expect($result)->toBeInstanceOf(PromiseInterface::class);
});
