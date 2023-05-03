<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\InputContent\InputMessageContent;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\Message\MessageEntity;

/**
 * Class InlineQueryResultVoice.
 *
 * Represents a link to a voice recording in an .OGG container encoded with OPUS.
 * By default, this voice recording will be sent by the user. Alternatively, you can
 * use input_message_content to send a message with the specified content instead of the
 * voice message.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultvoice
 *
 * @method $this id(string $string)                                            Required. Unique identifier for this result, 1-64 bytes
 * @method $this voiceUrl(string $string)                                      Required. A valid URL for the voice recording
 * @method $this title(string $string)                                         Required. Recording title
 * @method $this caption(string $string)                                       (Optional). Caption, 0-200 characters
 * @method $this parseMode(string $string)                                     (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this captionEntities(MessageEntity[] $captionEntities)             (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this voiceDuration(int $int)                                       (Optional). Recording duration in seconds
 * @method $this replyMarkup(InlineKeyboardMarkup $keyboardMarkup)             (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent(InputMessageContent $inputMessageContent) (Optional). Content of the message to be sent instead of the photo
 */
class InlineQueryResultVoice extends InlineQueryResult
{
    protected string $type = 'voice';
}
