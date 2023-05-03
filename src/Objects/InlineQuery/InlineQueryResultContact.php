<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\InputContent\InputMessageContent;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;

/**
 * Class InlineQueryResultContact.
 *
 * Represents a contact with a phone number. By default, this contact will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the contact.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcontact
 *
 * @method $this id(string $string)                                            Required. Unique identifier for this result, 1-64 Bytes
 * @method $this phoneNumber(string $string)                                   Required. Contact's phone number
 * @method $this firstName(string $string)                                     Required. Contact's first name
 * @method $this lastName(string $string)                                      (Optional). Contact's last name
 * @method $this vcard(string $string)                                         (Optional). Additional data about the contact in the form of a vCard, 0-2048 bytes
 * @method $this replyMarkup(InlineKeyboardMarkup $keyboardMarkup)             (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent(InputMessageContent $inputMessageContent) (Optional). Content of the message to be sent instead of the photo
 * @method $this thumbnailUrl(string $string)                                  (Optional). Url of the thumbnail for the result
 * @method $this thumbnailWidth(int $int)                                      (Optional). Thumbnail width
 * @method $this thumbnailHeight(int $int)                                     (Optional). Thumbnail height
 */
class InlineQueryResultContact extends InlineQueryResult
{
    protected string $type = 'contact';
}
