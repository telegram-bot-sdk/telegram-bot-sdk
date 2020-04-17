<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultCachedAudio.
 *
 * <code>
 * [
 *   'id'                     => '',  //  string                - Unique identifier for this result, 1-64 bytes
 *   'audio_file_id'          => '',  //  string                - A valid file identifier for the audio file
 *   'caption'                => '',  //  string                - (Optional). Caption, 0-200 characters
 *   'parse_mode'             => '',  //  string                - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the photo
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcachedaudio
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 bytes
 * @method $this setAudioFileId($string)            A valid file identifier for the audio file
 * @method $this setCaption($string)                (Optional). Caption, 0-200 characters
 * @method $this setParseMode($string)              (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this setReplyMarkup($object)            (Optional). Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    (Optional). Content of the message to be sent instead of the photo
 */
class InlineQueryResultCachedAudio extends InlineBaseObject
{
    protected string $type = 'audio';
}
