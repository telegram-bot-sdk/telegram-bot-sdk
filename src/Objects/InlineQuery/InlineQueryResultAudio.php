<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\InputContent\InputMessageContent;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\Message\MessageEntity;

/**
 * Class InlineQueryResultAudio.
 *
 * Represents a link to an MP3 audio file. By default, this audio file will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content
 * instead of the audio.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultaudio
 *
 * @method $this id(string $string) Required. Unique identifier for this result, 1-64 bytes
 * @method $this audioUrl(string $string) Required. A valid URL for the audio file
 * @method $this title(string $string) Required. Title
 * @method $this caption(string $string) (Optional). Caption, 0-200 characters
 * @method $this parseMode(string $string) (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this captionEntities(MessageEntity[] $captionEntities) (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this performer(string $string) (Optional). Performer
 * @method $this audioDuration(int $int) (Optional). Audio duration in seconds
 * @method $this replyMarkup(InlineKeyboardMarkup $keyboardMarkup) (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent(InputMessageContent $inputMessageContent) (Optional). Content of the message to be sent instead of the photo
 */
final class InlineQueryResultAudio extends InlineQueryResult
{
    protected string $type = 'audio';
}
