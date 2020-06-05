<?php

namespace Telegram\Bot\Tests\Unit;

use Illuminate\Contracts\Container\BindingResolutionException;
use PHPUnit\Framework\TestCase;
use Telegram\Bot\Bot;
use Telegram\Bot\BotManager;
use Telegram\Bot\Exceptions\TelegramSDKException;

class BotManagerTest extends TestCase
{
    protected BotManager $manager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->manager = new BotManager(
            [
                'use'                          => 'bot1',
                'bots'                         => [
                    'bot1' => [
                        'username' => 'BotOne_Bot',
                        'token'    => 'TOKEN1',
                        'commands' => [],
                    ],
                    'bot2' => [
                        'username' => 'BotTwo_Bot',
                        'token'    => 'TOKEN2',
                        'commands' => [],
                    ],
                    'bot3' => [
                        'username' => 'BotThree_Bot',
                        'token'    => 'TOKEN3',
                        'commands' => [],
                    ],
                ],
                'resolve_command_dependencies' => true,
                'commands'                     => [
                    //      Telegram\Bot\Commands\HelpCommand::class,
                ],
            ]
        );
    }

    /** @test */
    public function a_bots_manager_can_be_created_with_no_config()
    {
        $manager = new BotManager([]);

        $this->assertInstanceOf(BotManager::class, $manager);
    }

    /**
     * @test
     * @throws BindingResolutionException
     */
    public function a_bot_must_be_configured_before_it_can_be_used()
    {
        $this->expectException(TelegramSDKException::class);

        $this->manager->bot('demo');
    }

    /**
     * @test
     * @throws TelegramSDKException
     * @throws BindingResolutionException
     */
    public function if_no_bot_name_is_passed_the_default_bot_is_used()
    {
        $bot = $this->manager->bot();

        $this->assertSame('bot1', $bot->getConfig()['bot']);
    }

    /** @test */
    public function an_invalid_or_missing_config_parameter_returns_null()
    {
        $manager = new BotManager([]);

        $this->assertNull($manager->getDefaultBotName());
    }

    /**
     * @test
     * @throws TelegramSDKException
     * @throws BindingResolutionException
     */
    public function a_bot_can_be_removed_from_the_manager()
    {
        $this->manager->bot('bot1');
        $this->manager->bot('bot2');
        $this->manager->bot('bot3');
        $allBots = $this->manager->getBots();
        $this->manager->disconnect('bot2');
        $remainingBots = $this->manager->getBots();

        $this->assertCount(3, $allBots);
        $this->assertCount(2, $remainingBots);
        $this->assertArrayNotHasKey('bot2', $remainingBots);
    }

    /**
     * @test
     * @throws TelegramSDKException
     * @throws BindingResolutionException
     */
    public function a_bot_can_be_reconnected_to_the_manager()
    {
        $initialBots = $this->manager->getBots();
        $this->manager->reconnect('bot1');
        $connected = $this->manager->getBots();

        $this->assertCount(0, $initialBots);
        $this->assertCount(1, $connected);
        $this->assertArrayHasKey('bot1', $connected);
    }

    /**
     * @test can change the default bot name
     * @throws TelegramSDKException
     * @throws BindingResolutionException
     */
    public function can_change_the_default_bot_name()
    {
        $initialName = $this->manager->getDefaultBotName();
        $this->manager->setDefaultBotName('bot3');
        $newDefaultName = $this->manager->getDefaultBotName();

        $this->assertSame('bot1', $initialName);
        $this->assertSame('bot3', $newDefaultName);
    }

    /**
     * @test returns the correct bot config settings
     * @throws TelegramSDKException
     */
    public function returns_the_correct_bot_config_settings()
    {
        $config = $this->manager->getBotConfig('bot3');

        $this->assertArrayHasKey('bot', $config);
        $this->assertSame('bot3', $config['bot']);
    }

    /** @test it calls methods on the bot */
    public function it_calls_methods_on_the_bot()
    {
        $fakeBot = $this->getMockBuilder(Bot::class)->disableOriginalConstructor()->getMock();
        $fakeBot->expects($this->once())
            ->method('getConfig')
            ->willReturn(['bot' => 'fakeBot']);
        $fakeBot->expects($this->once())
            ->method('__call')
            ->with($this->equalTo('sendMessage'), $this->equalTo([[]]));

        $this->manager->setBot($fakeBot);

        $this->manager->bot('fakeBot')->sendMessage([]);
    }
}
