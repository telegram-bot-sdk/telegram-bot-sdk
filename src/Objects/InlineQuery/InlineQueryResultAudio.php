<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultAudio.
 *
 * Represents a link to an MP3 audio file. By default, this audio file will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content
 * instead of the audio.
 *
 * <code>
 * [
 *   'id'                     => '',  //  string                 - Required. Unique identifier for this result, 1-64 bytes
 *   'audio_url'              => '',  //  string                 - Required. A valid URL for the audio file
 *   'title'                  => '',  //  string                 - Required. Title
 *   'caption'                => '',  //  string                 - (Optional). Caption, 0-200 characters
 *   'parse_mode'             => '',  //  string                 - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 *   'caption_entities'       => '',  //  array                  - (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 *   'performer'              => '',  //  string                 - (Optional). Performer
 *   'audio_duration'         => '',  //  int                    - (Optional). Audio duration in seconds
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup   - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent    - (Optional). Content of the message to be sent instead of the photo
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultaudio
 *
 * @method $this id($string)                              Required. Unique identifier for this result, 1-64 bytes
 * @method $this audioUrl($string)                        Required. A valid URL for the audio file
 * @method $this title($string)                           Required. Title
 * @method $this caption($string)                         (Optional). Caption, 0-200 characters
 * @method $this parseMode($string)                       (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this captionEntities(array $messageEntity)    (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this performer($string)                       (Optional). Performer
 * @method $this audioDuration($int)                      (Optional). Audio duration in seconds
 * @method $this replyMarkup($object)                     (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent($object)             (Optional). Content of the message to be sent instead of the photo
 */
class InlineQueryResultAudio extends AbstractInlineObject
{
    protected string $type = 'audio';
}
