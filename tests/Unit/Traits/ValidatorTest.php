<?php

namespace Telegram\Bot\Tests\Unit\Traits;

use PHPUnit\Framework\TestCase;
use Telegram\Bot\Helpers\Validator;
use Telegram\Bot\Objects\Update;

class ValidatorTest extends TestCase
{

    /** @test it can detect a command in an update object */
    public function it_can_detect_a_command_in_an_update_object()
    {
        $this->assertFalse(Validator::hasCommand($this->updateWithNoCommands()));
        $this->assertFalse(Validator::hasCommand($this->updateWithNonCommandEntities()));
        $this->assertTrue(Validator::hasCommand($this->updateWithOneCommand()));
        $this->assertTrue(Validator::hasCommand($this->updateWithCaptionCommand()));
        $this->assertTrue(Validator::hasCommand($this->updateWithCommandMixedWithEntities()));
    }

    private function updateWithNoCommands()
    {
        return new Update(
            [
                'update_id' => 412826981,
                'message'   =>
                    [
                        'text' => 'Just a regular message',
                    ],
            ]
        );
    }

    private function updateWithOneCommand()
    {
        return new Update(
            [
                "update_id" => 304437407,
                "message"   => [
                    "text"     => "Hey guys check out this /image ",
                    "entities" => [
                        [
                            "offset" => 24,
                            "length" => 6,
                            "type"   => "bot_command",
                        ],
                    ],
                ],
            ]);
    }

    private function updateWithCommandMixedWithEntities()
    {
        return new Update(
            [
                'update_id' => 412826979,
                'message'   =>
                    [
                        'text'     => 'This is a message with multiple commands and  /demo command with some extra https://google.com entities and all types of goodies for you to see /anotherdemo well',
                        'entities' =>
                            [
                                0 =>
                                    [
                                        'offset' => 8,
                                        'length' => 9,
                                        'type'   => 'bold',
                                    ],
                                1 =>
                                    [
                                        'offset' => 46,
                                        'length' => 5,
                                        'type'   => 'bot_command',
                                    ],
                                2 =>
                                    [
                                        'offset' => 76,
                                        'length' => 18,
                                        'type'   => 'url',
                                    ],
                                3 =>
                                    [
                                        'offset' => 104,
                                        'length' => 4,
                                        'type'   => 'bold',
                                    ],
                                4 =>
                                    [
                                        'offset' => 108,
                                        'length' => 3,
                                        'type'   => 'italic',
                                    ],
                                5 =>
                                    [
                                        'offset' => 111,
                                        'length' => 6,
                                        'type'   => 'bold',
                                    ],
                                6 =>
                                    [
                                        'offset' => 144,
                                        'length' => 12,
                                        'type'   => 'bot_command',
                                    ],
                            ],
                    ],
            ]
        );
    }

    private function updateWithCaptionCommand()
    {
        return new Update(
            [
                'update_id' => 412826976,
                'message'   => [
                    'caption'          => 'This is a caption with a /demo command.',
                    'caption_entities' => [
                        0 =>
                            [
                                'offset' => 25,
                                'length' => 5,
                                'type'   => 'bot_command',
                            ],
                    ],
                ],
            ]
        );
    }

    private function updateWithNonCommandEntities()
    {
        return new Update(
            [
                'update_id' => 412826982,
                'message'   =>
                    [
                        'text'     => 'A simple message with Entities and urls https://qwert.net but no command entities',
                        'entities' =>
                            [
                                0 =>
                                    [
                                        'offset' => 2,
                                        'length' => 14,
                                        'type'   => 'italic',
                                    ],
                                1 =>
                                    [
                                        'offset' => 40,
                                        'length' => 17,
                                        'type'   => 'url',
                                    ],
                            ],
                    ],
            ]
        );
    }
}
