<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\InputContent\InputMessageContent;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;

/**
 * Class InlineQueryResultArticle.
 *
 * Represents a link to an article or web page.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultarticle
 *
 * @method $this id(string $string)                               Required. Unique identifier for this result, 1-64 Bytes
 * @method $this title(string $string)                            Required. Title of the result
 * @method $this inputMessageContent(InputMessageContent $object) Required. Content of the message to be sent.
 * @method $this replyMarkup(InlineKeyboardMarkup $object)        (Optional). Inline keyboard attached to the message
 * @method $this url(string $string)                              (Optional). URL of the result
 * @method $this hideUrl(bool $bool)                              (Optional). Pass True, if you don't want the URL to be shown in the message
 * @method $this description(string $string)                      (Optional). Short description of the result
 * @method $this thumbnailUrl(string $string)                     (Optional). Url of the thumbnail for the result
 * @method $this thumbnailWidth(int $int)                         (Optional). Thumbnail width
 * @method $this thumbnailHeight(int $int)                        (Optional). Thumbnail height
 */
final class InlineQueryResultArticle extends InlineQueryResult
{
    protected string $type = 'article';
}
