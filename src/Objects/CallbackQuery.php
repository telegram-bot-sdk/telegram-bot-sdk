<?php

namespace Telegram\Bot\Objects;

/**
 * Class CallbackQuery.
 *
 * @link https://core.telegram.org/bots/api#callbackquery
 *
 * @property int     $id                 Unique message identifier.
 * @property User    $from               Sender.
 * @property Message $message            (Optional). Message with the callback button that originated the query. Note that message content and message date will not be available if the message is too old.
 * @property string  $inline_message_id  (Optional). Identifier of the message sent via the bot in inline mode, that originated the query.
 * @property string  $chat_instance      Identifier, uniquely corresponding to the chat to which the message with the callback button was sent. Useful for high scores in games.
 * @property string  $data               (Optional). Data associated with the callback button. Be aware that a bad client can send arbitrary data in this field.
 * @property string  $game_short_name    (Optional). Short name of a Game to be returned, serves as the unique identifier for the game
 */
class CallbackQuery
{
}
