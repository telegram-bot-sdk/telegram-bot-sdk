<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultArticle.
 *
 * To initialise quickly you can use the following array to construct the object
 * <code>
 * [
 *   'id'                     => '', // string                 - Unique identifier for this result, 1-64 Bytes
 *   'title'                  => '', // string                 - Title of the result
 *   'input_message_content'  => '', // InputMessageContent    - Content of the message to be sent.
 *   'reply_markup'           => '', // InlineKeyboardMarkup   - (Optional). Inline keyboard attached to the message
 *   'url'                    => '', // string                 - (Optional). URL of the result
 *   'hide_url'               => '', // bool                   - (Optional). Pass True, if you don't want the URL to be shown in the message
 *   'description'            => '', // string                 - (Optional). Short description of the result
 *   'thumb_url'              => '', // string                 - (Optional). Url of the thumbnail for the result
 *   'thumb_width'            => '', // int                    - (Optional). Thumbnail width
 *   'thumb_height'           => '', // int                    - (Optional). Thumbnail height
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultarticle
 *
 * @method $this setId($string)                  Unique identifier for this result, 1-64 Bytes
 * @method $this setTitle($string)               Title of the result
 * @method $this setInputMessageContent($object) Content of the message to be sent.
 * @method $this setReplyMarkup($object)         (Optional). Inline keyboard attached to the message
 * @method $this setUrl($string)                 (Optional). URL of the result
 * @method $this setHideUrl($bool)               (Optional). Pass True, if you don't want the URL to be shown in the message
 * @method $this setDescription($string)         (Optional). Short description of the result
 * @method $this setThumbUrl($string)            (Optional). Url of the thumbnail for the result
 * @method $this setThumbWidth($int)             (Optional). Thumbnail width
 * @method $this setThumbHeight($int)            (Optional). Thumbnail height
 */
class InlineQueryResultArticle extends InlineBaseObject
{
    protected string $type = 'article';
}
