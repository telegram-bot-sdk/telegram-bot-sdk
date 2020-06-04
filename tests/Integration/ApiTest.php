<?php

namespace Telegram\Bot\Tests\Integration;

use BadMethodCallException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use RuntimeException;
use Telegram\Bot\Api;
use Telegram\Bot\Events\UpdateEvent;
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
    public function it_uses_guzzle_as_the_default_http_client_if_not_specified()
    {
        $client = $this->api->getClient()->getHttpClientHandler();

        $this->assertInstanceOf(GuzzleHttpClient::class, $client);
    }

    /** @test */
    public function it_forwards_calls_to_the_telegram_client()
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
        $fakeResponse = $this->createResponse([]);
        $this->setupQueuedResponses([$fakeResponse]);

        $result = $this->api->getUpdates();

        $this->assertCount(0, $result);
        $this->assertSame([], $result);
    }

    /** @test
     * @throws TelegramSDKException
     */
    public function the_correctly_formatted_bot_url_is_used_when_a_request_is_made()
    {
        $fakeResponse = $this->createResponse([]);
        $this->setupQueuedResponses([$fakeResponse]);

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
    public function the_correct_request_query_string_is_created_when_a_get_method_has_parameters()
    {
        $fakeResponse = $this->createResponse([]);
        $this->setupQueuedResponses([$fakeResponse]);

        $this->api->setHttpClientHandler($this->getClient([$fakeResponse]));
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
    public function the_correct_request_body_data_is_created_when_a_post_method_has_parameters()
    {
        $fakeResponse = $this->createResponse([]);
        $params = [
            'chat_id'                  => 12345678,
            'text'                     => 'lorem ipsum',
            'disable_web_page_preview' => true,
            'disable_notification'     => false,
            'reply_to_message_id'      => 99999999,
        ];

        $this->api->setHttpClientHandler($this->getClient([$fakeResponse]));
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
        $replyFromTelegram1 = $this->createResponse($data1);
        $replyFromTelegram2 = $this->createResponse($data2);

        $this->api->setHttpClientHandler($this->getClient([$replyFromTelegram1, $replyFromTelegram2]));

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
                'update_id' => 377695760,
            ],
        ];
        $this->setupQueuedResponses([$this->createResponse($data)]);

        $this->api->getUpdates();
        $lastResponse = $this->api->getLastResponse();

        $this->assertNotEmpty($lastResponse);
        $this->assertSame(377695760, $lastResponse->getDecodedBody()->result[0]->update_id);
        $this->assertInstanceOf(TelegramResponse::class, $lastResponse);
    }

    /**
     * @test
     * @throws
     */
    public function it_throws_an_exception_if_the_api_response_is_not_ok()
    {
        $badUpdateReply = $this->makeFakeServerErrorResponse(123, 'BadResponse Test');
        $this->setupQueuedResponses([$badUpdateReply]);

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

    /** @test
     * @throws TelegramSDKException
     */
//    public function it_can_use_async_promises_to_send_requests()
//    {
//        $data = '{"ok":true,"result":{"id":132883169,"is_bot":true,"first_name":"sdktesting","username":"sdktesting_bot","can_join_groups":true,"can_read_all_group_messages":true,"supports_inline_queries":true}}';
//
//        $replyFromTelegram = $this->makeFakeServerResponse(json_decode($data));
//        $this->api->setHttpClientHandler($this->getGuzzleHttpClient([$replyFromTelegram]));
//        $this->api->setAsyncRequest(true);
//
//        $user = $this->api->getMe();
//        $this->assertEmpty($user);
//    }

    /**
     * @test
     */
    public function when_a_method_uses_uploadFile_it_sends_the_request_using_multipart_format()
    {
        $this->setupQueuedResponses([$this->createResponse()]);

        $this->api->uploadFile(
            'randomMethod',
            [
                'chat_id'  => 123456789,
                'document' => 'AwADBAADYwADO1wlBuF1ogMa7HnMAg',
            ]);

        /** @var Request $request */
        $request = $this->getHistory()->pluck('request')->first();

        $this->assertStringContainsString('Content-Disposition: form-data; name="chat_id"', $request->getBody());
        $this->assertStringContainsString('Content-Disposition: form-data; name="document"', $request->getBody());
        $this->assertStringContainsString('AwADBAADYwADO1wlBuF1ogMa7HnMAg', $request->getBody());
        $this->assertSame('POST', $request->getMethod());
        $this->assertStringContainsString('multipart/form-data;', $request->getHeaderLine('Content-Type'));
    }

//    /** @test
//     * @throws TelegramSDKException
//     */
//    public function a_stream_can_be_used_as_a_file_upload()
//    {
//        $stream = stream_for('This is some text');
//        $this->setupQueuedResponses(['update_id' => 123]);
//
//        $result = $this->api->sendDocument(
//            [
//                'chat_id'  => '123456789',
//                'document' => InputFile::contents($stream, 'myFile.txt'),
//            ]);
//
//        /** @var Request $request */
//        $request = $this->getHistory()->pluck('request')->first();
//        $body = (string)$request->getBody();
//
//        $this->assertInstanceOf(Message::class, $result);
//        $this->assertStringContainsString('This is some text', $body);
//        $this->assertStringContainsString('Content-Disposition: form-data; name="document"; filename="myFile.txt"',
//                                          $body);
//    }

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
                ]);
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
            ]);

        $this->api->setWebhook(
            [
                'url'         => 'https://example.com',
                'certificate' => 'php://temp',
            ]);

        /** @var Request $request */
        $response1 = (string)$this->getHistory()->pluck('request')->first()->getBody();
        $response2 = (string)$this->getHistory()->pluck('request')->last()->getBody();

        $this->assertStringContainsString('Content-Disposition: form-data; name="certificate"; filename="customKeyName.key"',
                                          $response1);
        $this->assertStringContainsString('THISISSOMERANDOMKEYDATA', $response1);
        $this->assertStringContainsString('Content-Disposition: form-data; name="certificate"; filename="certificate.pem"',
                                          $response2);
    }

    /** @test check the webhook works */
    public function check_the_webhook_works_and_can_emmit_an_event()
    {
        $emitter = $this->prophesize(Emitter::class);

        $api = $this->getApi();

        $update = $api->getWebhookUpdate();

        //We can't pass test data to the webhook because it relies on the read only stream php://input
        $this->assertEmpty($update);
        $emitter->emit(Argument::type(UpdateEvent::class))->shouldHaveBeenCalled();
    }

    /** @test */
    public function the_commands_handler_can_get_all_commands()
    {
        $api = $this->getApi();

        $api->addCommands($this->commandGenerator(4)->all());
        $commands = $api->getCommands();

        $this->assertCount(4, $commands);
    }

    /** @test */
    public function the_command_handler_can_use_getUpdates_to_process_updates_and_mark_updates_read()
    {
        $updateData = $this->createResponse([
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
                                                      'text'       => 'Just some text',
                                                  ],
                                              ],
                                          ]);
        $markAsReadData = $this->createResponse([]);
        $api = $this->getApi($this->getClient([$updateData, $markAsReadData]));

        $updates = collect($api->commandsHandler());
        $markAsReadRequest = $this->getHistory()->pluck('request')->last();

        $updates->each(function ($update) {
            $this->assertInstanceOf(Update::class, $update);
        });
        $this->assertEquals('Just some text', $updates->first()->getMessage()->text);
        $this->assertEquals('377695760', $updates->first()->updateId);
        $this->assertStringContainsString('offset=377695761&limit=1', $markAsReadRequest->getUri()->getQuery());
    }

    /** @test */
    public function the_command_handler_when_using_webhook_to_process_updates_for_commands_will_return_the_update()
    {
        $updateData = $this->createResponse([]);
        $api = $this->getApi($this->getClient([$updateData]));

        //We cannot mock out the php://input stream so we can't send any test data.
        // Instead, we can only just check it returns back an update object.
        $update = $api->commandsHandler(true);

        $this->assertInstanceOf(Update::class, $update);
    }

    protected function setupQueuedResponses(array $data): void
    {
        $this->api->setHttpClientHandler($this->getClient($data));
    }
}
