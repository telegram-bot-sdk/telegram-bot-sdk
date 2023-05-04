<?php

namespace Telegram\Bot\Objects\BotCommand;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * This object represents a bot command.
 *
 * @link https://core.telegram.org/bots/api#botcommand
 *
 * @method $this command(string $command)          Text of the command; 1-32 characters. Can contain only lowercase English letters, digits and underscores.
 * @method $this description(string $description)  Description of the command; 1-256 characters.
 */
class BotCommand extends AbstractCreateObject
{
}
