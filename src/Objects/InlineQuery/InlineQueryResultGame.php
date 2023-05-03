<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;

/**
 * Class InlineQueryResultGame.
 *
 * Represents a Game.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultgame
 *
 * @method $this id(string $string)                                 Required. Unique identifier for this result, 1-64 Bytes.
 * @method $this gameShortName(string $string)                      Required. Short name of the game.
 * @method $this replyMarkup(InlineKeyboardMarkup $keyboardMarkup)  (Optional). Inline keyboard attached to the message
 */
class InlineQueryResultGame extends InlineQueryResult
{
    protected string $type = 'game';
}
