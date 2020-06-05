<?php

namespace Telegram\Bot\Tests\Unit\Commands;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;
use Telegram\Bot\BotManager;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Commands\CommandBus;
use Telegram\Bot\Commands\CommandInterface;
use Telegram\Bot\Exceptions\TelegramCommandException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Update;

class CommandBusTest extends TestCase
{
    protected CommandBus $bus;
    protected Container $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = Container::getInstance();
        $bot = (new BotManager(['bots' => ['testBot' => ['token' => '123']]]))->bot('testBot');

        $this->bus = $this->container->make(CommandBus::class, compact('bot'));
    }

    /** @test */
    public function it_can_add_a_command_to_the_bus()
    {
        $this->assertCount(0, $this->bus->getCommands());

        $this->bus->addCommand('command1', 'Fake\Command\Class');

        $this->assertCount(1, $this->bus->getCommands());
    }

    /** @test */
    public function it_can_add_multiple_commands_to_the_bus()
    {
        $this->assertCount(0, $this->bus->getCommands());
        $this->bus->addCommands($this->commandGenerator(4));

        $this->assertCount(4, $this->bus->getCommands());
    }

    /** @test */
    public function it_can_remove_a_command_from_the_bus()
    {
        $initCommandList = $this->bus->getCommands();
        $this->bus->addCommands($this->commandGenerator(4));
        $commandList = $this->bus->getCommands();
        $this->bus->removeCommand('command2');
        $newCommandList = $this->bus->getCommands();

        $this->assertCount(0, $initCommandList);
        $this->assertCount(4, $commandList);
        $this->assertArrayHasKey('command2', $commandList);
        $this->assertCount(3, $newCommandList);
        $this->assertArrayNotHasKey('command2', $newCommandList);
    }

    /** @test */
    public function it_can_remove_multiple_commands_from_the_bus()
    {
        $this->bus->addCommands($this->commandGenerator(4));
        $commandList = $this->bus->getCommands();

        $this->bus->removeCommands(['command2', 'command4']);
        $newCommandList = $this->bus->getCommands();

        $this->assertCount(4, $commandList);
        $this->assertArrayHasKey('command2', $commandList);
        $this->assertArrayHasKey('command4', $commandList);
        $this->assertCount(2, $newCommandList);
        $this->assertArrayNotHasKey('command2', $newCommandList);
        $this->assertArrayNotHasKey('command4', $newCommandList);
    }

    /** @test */
    public function it_uses_the_last_added_command_if_a_duplicate_command_is_supplied()
    {
        $firstBatch = $this->commandGenerator(4);
        $secondBatch = ['command2' => 'DummyClass'];

        $this->bus->addCommands($firstBatch);
        $this->bus->addCommands($secondBatch);
        $commandList = $this->bus->getCommands();

        $this->assertCount(4, $commandList);
        $this->assertSame($commandList['command2'], $secondBatch['command2']);
        $this->assertNotSame($commandList['command2'], $firstBatch['command2']);
    }

    /** @test */
    public function it_can_parse_the_command_name_from_a_message_correctly()
    {
        $message01 = 'The command is /demo and is in the middle of the string.';
        $message02 = '/demo command is at the start of a string.';
        $message03 = 'The command is /demo@MyDemo_Bot and is in the middle of the string.';
        $message04 = '/demo@MyDemo_Bot command is at the start of a string.';

        $commandName01 = $this->bus->parseCommand($message01, 15, 5);
        $commandName02 = $this->bus->parseCommand($message02, 0, 5);
        $commandName03 = $this->bus->parseCommand($message03, 15, 16);
        $commandName04 = $this->bus->parseCommand($message04, 0, 16);

        $this->assertEquals('demo', $commandName01);
        $this->assertEquals('demo', $commandName02);
        $this->assertEquals('demo', $commandName03);
        $this->assertEquals('demo', $commandName04);
    }

    /** @test */
    public function it_throws_an_exception_if_parsing_for_a_command_in_a_message_with_no_text()
    {
        $this->expectException(InvalidArgumentException::class);
        $message = '';

        $this->bus->parseCommand($message, 5, 5);
    }

    /**
     * @test
     * @throws TelegramCommandException
     */
    public function it_throws_an_exception_if_no_class_exists_for_the_command_name_supplied()
    {
        $this->expectException(TelegramSDKException::class);
        $this->bus->addCommand('command', '\Class\That\Doesnt\Exist');
        $this->bus->resolveCommand('command');
    }

    /**
     * @test
     * @throws TelegramCommandException
     */
    public function it_throws_an_exception_if_command_is_not_an_instance_of_command_interface()
    {
        $this->expectException(TelegramSDKException::class);

        $this->bus->addCommand('command', stdClass::class);
        $this->bus->resolveCommand('command');
    }

    /**
     * @test
     * @throws TelegramCommandException
     * @throws TelegramSDKException
     */
    public function it_can_resolve_a_valid_command()
    {
        $this->bus->addCommand('command', 'fakeCommand');
        $this->container->instance('fakeCommand', $this->getMockCommand());

        $command = $this->bus->resolveCommand('command');

        $this->assertInstanceOf(CommandInterface::class, $command);
    }

    /**
     * @test
     * @throws TelegramCommandException
     */
    public function it_permits_a_command_object_to_be_resolved()
    {
        $command = $this->bus->resolveCommand($this->getMockCommand());

        $this->assertInstanceOf(CommandInterface::class, $command);
    }

    /** @test */
    public function it_handles_an_update_with_a_command_entity()
    {
        $update = $this->getUpdate();
        $command = $this->getMockCommand();

        $command->expects($this->once())->method('handle');

        $this->bus->addCommand('command', 'fakeCommand');
        $this->container->instance('fakeCommand', $command);

        $returnedUpdate = $this->bus->handler($update);

        $this->assertSame($update, $returnedUpdate);
    }

    /** @test */
    public function it_checks_the_handle_method_is_called_when_a_command_is_execute()
    {
        $update = $this->getUpdate();
        $command = $this->getMockCommand();

        $command->expects($this->once())->method('handle');

        $this->bus->addCommand('command', 'fakeCommand');
        $this->container->instance('fakeCommand', $command);

        $this->bus->handler($update);
    }

    /** @test */
    public function it_checks_all_command_properties_are_set_when_executed()
    {
        $update = $this->getUpdate();
        $command = $this->getMockBuilder(CommandParametersAllRequired::class)->getMock();

        $command->expects($this->once())
            ->method('setCommandBus')
            ->with($this->equalTo($this->bus))
            ->willReturn($command);

        $command->expects($this->once())
            ->method('setBot')
            ->with($this->equalTo($this->bus->getBot()))
            ->willReturn($command);

        $command->expects($this->once())
            ->method('setUpdate')
            ->with($this->equalTo($update))
            ->willReturn($command);

        $command->expects($this->once())
            ->method('setArguments')
            ->with($this->equalTo(
                [
                    'fruit'  => 'apple',
                    'animal' => 'horse',
                    'colour' => 'orange',
                ]));

        $this->bus->addCommand('command', CommandParametersAllRequired::class);
        $this->container->instance(CommandParametersAllRequired::class, $command);

        $this->bus->handler($update);
    }

    /** @test */
    public function it_sets_which_arguments_were_not_provided()
    {
        //Lets only provide 2 out of the 3 required arguments.
        $update = $this->getUpdate('apple horse');
        $command = $this->getMockBuilder(CommandParametersAllRequired::class)->getMock();

        $command->expects($this->once())
            ->method('setArgumentsNotProvided')
            ->with($this->equalTo(['colour']));

        $this->bus->addCommand('command', CommandParametersAllRequired::class);
        $this->container->instance(CommandParametersAllRequired::class, $command);

        $this->bus->handler($update);
    }

    /** @test */
    public function it_checks_a_commands_handle_function_is_called_with_the_correct_arguments()
    {
        $update = $this->getUpdate();
        $command = $this->getMockBuilder(CommandParametersAllRequired::class)->getMock();

        $command->expects($this->once())->method('handle')
            ->with(
                $this->equalTo('apple'),
                $this->equalTo('horse'),
                $this->equalTo('orange'),
            );

        $this->bus->addCommand('command', CommandParametersAllRequired::class);
        $this->container->instance(CommandParametersAllRequired::class, $command);

        $this->bus->handler($update);
    }


    /** @test */
    public function it_checks_a_commands_handle_function_is_called_with_the_correct_arguments_when_they_are_optional()
    {
        $update = $this->getUpdate('apple');
        $command = $this->getMockBuilder(CommandParametersHasOptional::class)->getMock();

        $command->expects($this->once())->method('handle')
            ->with(
                $this->equalTo('apple'),
                $this->isNull()
            );

        $this->bus->addCommand('command', CommandParametersHasOptional::class);
        $this->container->instance(CommandParametersHasOptional::class, $command);

        $this->bus->handler($update);
    }

    /** @test */
    public function it_checks_a_commands_handle_function_is_called_with_the_correct_arguments_when_they_have_regex()
    {
        $update = $this->getUpdate('apple 456AB purple');
        //This command will match the regex.
        $command = $this->getMockBuilder(CommandParametersHasRegex::class)->getMock();
        $command->expects($this->once())->method('handle')
            ->with(
                $this->equalTo('apple'),
                $this->equalTo('456AB'),
                $this->equalTo('purple'),
            );

        $this->bus->addCommand('command', CommandParametersHasRegex::class);
        $this->container->instance(CommandParametersHasRegex::class, $command);

        $this->bus->handler($update);
    }

    /** @test */
    public function it_checks_a_command_with_unmatched_regex_for_a_parameter_gets_processed_correctly()
    {
        $update = $this->getUpdate('apple purple');
        //This command will not match the regex
        $command = $this->getMockBuilder(CommandParametersHasRegex::class)->getMock();
        $command->expects($this->once())->method('handle')
            ->with(
                $this->equalTo('apple'),
                $this->equalTo(''),
                $this->equalTo('purple'),
            );

        $this->bus->addCommand('command', CommandParametersHasRegex::class);
        $this->container->instance(CommandParametersHasRegex::class, $command);

        $this->bus->handler($update);
    }

    /** @test */
    public function it_checks_the_failed_method_gets_called_with_the_correct_parameters()
    {
        $update = $this->getUpdate('apple');
        $command = $this->getMockBuilder(CommandParametersAllRequired::class)->getMock();

        $command->expects($this->never())->method('handle');
        $command->expects($this->once())->method('setArgumentsNotProvided')->willReturnSelf();
        $command->expects($this->once())->method('failed')
            ->with(
                $this->callback(function ($params) {
                    return $params[0] === 'animal' && $params[1] === 'colour';
                }),
                $this->isInstanceOf(TelegramCommandException::class),
            );

        $this->bus->addCommand('command', CommandParametersAllRequired::class);
        $this->container->instance(CommandParametersAllRequired::class, $command);

        $this->bus->handler($update);
    }

    /**
     * @return MockObject|Command
     */
    protected function getMockCommand()
    {
        return $this->getMockBuilder(Command::class)
            ->setMockClassName('FakeCommand')
            ->addMethods(['handle'])
            ->getMock();
    }

    protected function commandGenerator($numberRequired): array
    {
        return Collection::times($numberRequired)
            ->mapWithKeys(function ($int) {
                return [
                    "command$int" => "ClassName$int",
                ];
            })
            ->all();
    }

    protected function getUpdate($commandArguments = 'apple horse orange')
    {
        return new Update(
            [
                'message' => [
                    'text'     => '/command ' . $commandArguments,
                    'entities' => [
                        [
                            'type'   => 'bot_command',
                            'offset' => 0,
                            'length' => 8,
                        ],
                    ],
                ],
            ]
        );
    }
}

class CommandParametersAllRequired extends Command
{
    public function handle($fruit, $animal, $colour)
    {
    }
}

class CommandParametersHasOptional extends Command
{
    public function handle($fruit, $animal = null)
    {
    }
}

class CommandParametersHasRegex extends Command
{
    public function handle($fruit, $staffId = '{\d{3}\w{2}}', $colour)
    {
    }
}
