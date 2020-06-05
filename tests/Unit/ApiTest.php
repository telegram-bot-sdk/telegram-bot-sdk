<?php

namespace Telegram\Bot\Tests\Unit;

use BadMethodCallException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Http\GuzzleHttpClient;
use Telegram\Bot\Http\TelegramClient;
use Telegram\Bot\Http\TelegramResponse;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Tests\Traits\GuzzleMock;

class ApiTest extends TestCase
{
    /**
     * @var Api
     */
    protected Api $api;

    protected function setUp(): void
    {
        parent::setUp();
        $this->api = new Api('token');
    }

    use GuzzleMock;

    /** @test */
    public function it_returns_the_correct_token()
    {
        $this->assertSame('token', $this->api->getToken());
    }

    /** @test */
    public function it_uses_a_telegram_client()
    {
        $this->assertInstanceOf(TelegramClient::class, $this->api->getClient());
    }

    /** @test */
    public function it_uses_guzzle_as_the_default_http_client()
    {
        $client = $this->api->getClient()->getHttpClientHandler();

        $this->assertInstanceOf(GuzzleHttpClient::class, $client);
    }

    /** @test */
    public function it_forwards_method_calls_to_the_telegram_client()
    {
        $fakeTelegramClient = $this->getMockBuilder(TelegramClient::class)->getMock();
        $fakeTelegramClient->expects($this->once())->method('post')->with('endpoint', []);
        $this->api->setClient($fakeTelegramClient);

        $this->api->post('endpoint', []);
    }

    /**
     * @test
     * @throws TelegramSDKException
     */
    public function it_returns_an_empty_array_if_there_are_no_updates()
    {
        $this->setupQueuedResponses([$this->createResponse()]);

        $result = $this->api->getUpdates();

        $this->assertCount(0, $result);
        $this->assertSame([], $result);
    }

    /** @test */
    public function it_ensures_all_updates_returned_via_long_polling_are_returned_as_update_objects()
    {
        $this->setupQueuedResponses(
            [
                $this->createResponse(
                    [
                        ["update_id" => 1],
                        ["update_id" => 2],
                        ["update_id" => 3],
                    ]
                ),
            ]
        );

        $updates = $this->api->getUpdates();

        $this->assertCount(3, $updates);
        collect($updates)->each(fn ($update) => $this->assertInstanceOf(Update::class, $update));
    }

    /**
     * @test
     * @throws TelegramSDKException
     */
    public function it_creates_the_proper_bot_request_url()
    {
        $this->setupQueuedResponses([$this->createResponse()]);

        $this->api->getMe();

        /** @var Request $request */
        $request = $this->getHistory()->pluck('request')->first();

        $this->assertSame('https', $request->getUri()->getScheme());
        $this->assertSame('api.telegram.org', $request->getUri()->getHost());
        $this->assertSame('/bottoken/getMe', $request->getUri()->getPath());
    }

    /**
     * @test
     * @throws TelegramSDKException
     */
    public function it_creates_the_proper_query_string_when_get_request_is_made()
    {
        $this->setupQueuedResponses([$this->createResponse()]);

        $this->api->getChatMember([
                                      'chat_id' => 123456789,
                                      'user_id' => 888888888,
                                  ]);

        /** @var Request $request */
        $request = $this->getHistory()->pluck('request')->first();

        $this->assertSame('', (string)$request->getBody(), 'The get request had a body when it should be blank.');
        $this->assertSame('https', $request->getUri()->getScheme());
        $this->assertSame('api.telegram.org', $request->getUri()->getHost());
        $this->assertSame('/bottoken/getChatMember', $request->getUri()->getPath());
        $this->assertSame('chat_id=123456789&user_id=888888888', $request->getUri()->getQuery());
    }

    /**
     * @test
     * @throws TelegramSDKException
     */
    public function it_creates_the_proper_structure_when_a_post_request_is_made()
    {
        $this->setupQueuedResponses([$this->createResponse()]);

        $params = [
            'chat_id'                  => 12345678,
            'text'                     => 'lorem ipsum',
            'disable_web_page_preview' => true,
            'disable_notification'     => false,
            'reply_to_message_id'      => 99999999,
        ];

        $this->api->sendMessage($params);

        /** @var Request $request */
        $request = $this->getHistory()->pluck('request')->first();

        $this->assertInstanceOf(Stream::class, $request->getBody());
        $this->assertSame(json_encode($params), (string)$request->getBody());
        $this->assertSame('https', $request->getUri()->getScheme());
        $this->assertSame('api.telegram.org', $request->getUri()->getHost());
        $this->assertSame('/bottoken/sendMessage', $request->getUri()->getPath());
        $this->assertSame('', $request->getUri()->getQuery());
    }

    public function it_sends_the_request_in_multipart_format_when_a_method_uses_uploadFile()
    {
        $this->setupQueuedResponses([$this->createResponse()]);

        $this->api->uploadFile(
            'randomMethod',
            [
                'chat_id'  => 123456789,
                'document' => 'AwADBAADYwADO1wlBuF1ogMa7HnMAg',
            ]
        );

        /** @var Request $request */
        $request = $this->getHistory()->pluck('request')->first();

        $this->assertStringContainsString('Content-Disposition: form-data; name="chat_id"', $request->getBody());
        $this->assertStringContainsString('Content-Disposition: form-data; name="document"', $request->getBody());
        $this->assertStringContainsString('AwADBAADYwADO1wlBuF1ogMa7HnMAg', $request->getBody());
        $this->assertSame('POST', $request->getMethod());
        $this->assertStringContainsString('multipart/form-data;', $request->getHeaderLine('Content-Type'));
    }

    /**
     * @test
     * @throws TelegramSDKException
     */
    public function it_returns_decoded_update_objects_when_updates_are_available()
    {
        $data1 = [
            [
                'update_id' => 377695760,
                'message'   => [
                    'message_id' => 749,
                    'from'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                    ],
                    'chat'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                        'type'       => 'private',
                    ],
                    'date'       => 1494623093,
                    'text'       => 'Test1',
                ],
            ],
            [
                'update_id' => 377695761,
                'message'   => [
                    'message_id' => 750,
                    'from'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                    ],
                    'chat'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                        'type'       => 'private',
                    ],
                    'date'       => 1494623095,
                    'text'       => 'Test2',
                ],
            ],
        ];
        $data2 = [
            [
                'update_id' => 377695762,
                'message'   => [
                    'message_id' => 751,
                    'from'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                    ],
                    'chat'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                        'type'       => 'private',
                    ],
                    'date'       => 1494623093,
                    'text'       => 'Test3',
                ],
            ],
            [
                'update_id' => 377695763,
                'message'   => [
                    'message_id' => 752,
                    'from'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                    ],
                    'chat'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                        'type'       => 'private',
                    ],
                    'date'       => 1494623095,
                    'text'       => 'Test4',
                ],
            ],
        ];

        $this->setupQueuedResponses([$this->createResponse($data1), $this->createResponse($data2)]);

        $firstUpdates = $this->api->getUpdates();
        $secondUpdates = $this->api->getUpdates();

        $this->assertCount(2, $firstUpdates);
        $this->assertSame(377695760, $firstUpdates[0]->update_id);
        $this->assertSame('Test1', $firstUpdates[0]->message->text);
        $this->assertSame(377695761, $firstUpdates[1]->update_id);
        $this->assertSame('Test2', $firstUpdates[1]->message->text);

        $this->assertCount(2, $secondUpdates);
        $this->assertSame(377695762, $secondUpdates[0]->update_id);
        $this->assertSame('Test3', $secondUpdates[0]->message->text);
        $this->assertSame(377695763, $secondUpdates[1]->update_id);
        $this->assertSame('Test4', $secondUpdates[1]->message->text);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_a_method_called_does_not_exist()
    {
        $this->expectException(BadMethodCallException::class);
        $badMethod = 'getBadMethod'; //To stop errors in ide!

        $this->api->$badMethod();
    }

    /**
     * @test
     * @throws TelegramSDKException
     */
    public function it_checks_the_lastResponse_property_gets_populated_after_a_request()
    {
        $data = [
            [
                'update_id' => 123456789,
            ],
        ];
        $this->setupQueuedResponses([$this->createResponse($data)]);

        $this->api->getUpdates();
        $lastResponse = $this->api->getLastResponse();

        $this->assertNotEmpty($lastResponse);
        $this->assertSame(123456789, $lastResponse->getDecodedBody()->result[0]->update_id);
        $this->assertInstanceOf(TelegramResponse::class, $lastResponse);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_api_response_is_not_ok()
    {
        $errorResponse = $this->createErrorResponse(123, 'BadResponse Test');
        $this->setupQueuedResponses([$errorResponse]);

        try {
            $this->api->getUpdates();
        } catch (TelegramSDKException $exception) {
            $this->assertEquals(123, $exception->getCode());
            $this->assertEquals('BadResponse Test', $exception->getMessage());

            return;
        }

        $this->fail('Should have caught a TelegramSDKException exception. The update was a bad response.');
    }

    /**
     * @test
     */
    public function it_throws_exception_if_invalid_chatAction_is_sent()
    {
        $this->expectException(TelegramSDKException::class);
        $this->api->sendChatAction(['action' => 'Eating']);
    }

    /**
     * @test
     * @throws TelegramSDKException
     */
    public function a_file_that_does_not_exist_should_throw_an_error_when_being_uploaded()
    {
        try {
            $this->api->sendDocument(
                [
                    'chat_id'  => '123456789',
                    'document' => InputFile::file('/path/to/nonexisting/file/test.pdf'),
                ]
            );
        } catch (RuntimeException $exception) {
            $this->assertStringContainsString(
                'Unable to open /path/to/nonexisting/file/test.pdf',
                $exception->getMessage()
            );
            return;
        }

        $this->fail('Should have caught a RuntimeException due to file not existing');
    }

    /** @test
     * @throws TelegramSDKException
     */
    public function it_can_set_a_webhook_with_its_own_certificate_succcessfully()
    {
        $pubKey = "-----BEGIN PUBLIC KEY-----\nTHISISSOMERANDOMKEYDATA\n-----END PUBLIC KEY-----";
        $this->setupQueuedResponses([$this->createResponse(true), $this->createResponse(true)]);

        // If the user uses the INPUTFILE class to send the webhook cert, the filename provided will override
        // the default name of certificate.pem
        $this->api->setWebhook(
            [
                'url'         => 'https://example.com',
                'certificate' => InputFile::contents($pubKey, 'customKeyName.key'),
            ]
        );

        //Default certificate name should be used.
        $this->api->setWebhook(
            [
                'url'         => 'https://example.com',
                'certificate' => 'php://temp',
            ]
        );

        /** @var Request $request */
        $response1 = (string)$this->getHistory()->pluck('request')->first()->getBody();
        $response2 = (string)$this->getHistory()->pluck('request')->last()->getBody();

        $this->assertStringContainsString(
            'Content-Disposition: form-data; name="certificate"; filename="customKeyName.key"',
            $response1
        );
        $this->assertStringContainsString('THISISSOMERANDOMKEYDATA', $response1);
        $this->assertStringContainsString(
            'Content-Disposition: form-data; name="certificate"; filename="certificate.pem"',
            $response2
        );
    }

    protected function setupQueuedResponses(array $data): void
    {
        $this->api->setHttpClientHandler($this->getClient($data));
    }
}
