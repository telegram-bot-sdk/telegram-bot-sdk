<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultGif.
 *
 * Represents a link to an animated GIF file. By default, this animated GIF file will be sent by the user with
 * optional caption. Alternatively, you can use input_message_content to send a message with the specified content
 * instead of the animation.
 *
 * <code>
 * [
 *   'id'                     => '',  //  string                - Required. Unique identifier for this result, 1-64 bytes
 *   'gif_url'                => '',  //  string                - Required. A valid URL for the GIF file. File size must not exceed 1MB
 *   'gif_width'              => '',  //  int                   - (Optional). Width of the GIF
 *   'gif_height'             => '',  //  int                   - (Optional). Height of the GIF
 *   'gif_duration'           => '',  //  int                   - (Optional). Duration of the GIF
 *   'thumb_url'              => '',  //  string                - Required. URL of the static thumbnail for the result (jpeg or gif)
 *   'title'                  => '',  //  string                - (Optional). Title for the result
 *   'caption'                => '',  //  string                - (Optional). Caption of the GIF file to be sent, 0-200 characters
 *   'caption_entities'       => '',  //  array                 - (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 *   'parse_mode'             => '',  //  string                - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the photo
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultgif
 *
 * @method $this id($string)                             Required. Unique identifier for this result, 1-64 bytes
 * @method $this gifUrl($string)                         Required. A valid URL for the GIF file. File size must not exceed 1MB
 * @method $this gifWidth($int)                          (Optional). Width of the GIF
 * @method $this gifHeight($int)                         (Optional). Height of the GIF
 * @method $this gifDuration($int)                       (Optional). Duration of the GIF
 * @method $this thumbUrl($string)                       Required. URL of the static (JPEG or GIF) or animated (MPEG4) thumbnail for the result
 * @method $this thumb_mime_type($string)                (Optional). MIME type of the thumbnail, must be one of “image/jpeg”, “image/gif”, or “video/mp4”. Defaults to “image/jpeg”
 * @method $this title($string)                          (Optional). Title for the result
 * @method $this caption($string)                        (Optional). Caption of the GIF file to be sent, 0-200 characters
 * @method $this parseMode($string)                      (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this captionEntities(array $messageEntity)   (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this replyMarkup($object)                    (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent($object)            (Optional). Content of the message to be sent instead of the photo
 */
class InlineQueryResultGif extends AbstractInlineObject
{
    protected string $type = 'gif';
}
