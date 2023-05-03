<?php

namespace Telegram\Bot\Objects\InputContent;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * This object describes the bot's menu button in a private chat.
 * if a menu button other than MenuButtonDefault is set for a private chat, then it is applied in the chat. Otherwise the default menu button is applied. By default, the menu button opens the list of bot commands.
 */
abstract class InputMessageContent extends AbstractCreateObject
{
}
