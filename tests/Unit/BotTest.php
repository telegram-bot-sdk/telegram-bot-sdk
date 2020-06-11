<?php

namespace Telegram\Bot\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Telegram\Bot\Addon\AddonManager;
use Telegram\Bot\Api;
use Telegram\Bot\Bot;
use Telegram\Bot\Events\EventFactory;
use Telegram\Bot\Objects\Update;

class BotTest extends TestCase
{
    private AddonManager $addonManager;
    private EventFactory $eventFactory;
    private Api $api;
    private array $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = $this->config();
        $this->api = $this->getMockBuilder(Api::class)->getMock();
        $this->eventFactory = $this->getMockBuilder(EventFactory::class)->getMock();
        $this->addonManager = $this->getMockBuilder(AddonManager::class)->getMock();
    }

//    /** @test */
//    public function it_checks_confirmUpdate_is_called_when_using_getUpdates_way_of_retrieving_updates()
//    {
//         //I Give up.
//        $update = new Update(
//            [
//                'update_id' => '12345',
//                'message'   => ['message_id' => 321, 'audio' => []],
//            ]);
//
//        $this->api
//            ->expects($this->once())
//            ->method('getUpdates')
//            ->will($this->returnValue([$update]));
//
//        $this->api
//            ->expects($this->once())
//            ->method('confirmUpdate')
//            ->with($this->equalTo(12345));
//
//        $bot = new Bot($this->api, $this->eventFactory, $this->addonManager, $this->config);
//
//        $bot->listen();
//    }

    /** @test */
    public function it_fires_all_appropiate_events_when_an_update_is_received()
    {
        $update = new Update(
            [
                'update_id' => '12345',
                'message'   => ['message_id' => 321, 'audio' => []],
            ]
        );

        $this->eventFactory
            ->expects($this->atLeastOnce())
            ->method('dispatch')
            ->withConsecutive(
                [$this->equalTo('update')],
                [$this->equalTo('message')],
                [$this->equalTo('message.audio')]
            );

        $bot = new Bot($this->api, $this->eventFactory, $this->addonManager, $this->config);

        $bot->dispatchUpdateEvent($update);
    }

    private function config()
    {
        return [
            'username' => 'test_bot',
            'token'    => '12345:abcde',
            'bot'      => 'test',
            'global'   =>
                [
                    'use' => 'test',
                ],
        ];
    }
}
