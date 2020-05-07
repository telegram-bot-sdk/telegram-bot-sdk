<?php

namespace Telegram\Bot\Objects\InputContent;

use Telegram\Bot\Objects\InlineQuery\InlineBaseObject;

/**
 * Class InputContactMessageContent.
 *
 * Represents the content of a contact message to be sent as the result of an inline query.
 *
 * <code>
 * [
 *   'phone_number'  => '',  //  string  - Required. Contact's phone number
 *   'first_name'    => '',  //  string  - Required. Contact's first name
 *   'last_name'     => '',  //  string  - (Optional). Contact's last name
 *   'vcard'         => '',  //  string  - (Optional). Additional data about the contact in the form of a vCard, 0-2048 bytes
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inputcontactmessagecontent
 *
 * @method $this phoneNumber($string) Required. Contact's phone number
 * @method $this firstName($string)   Required. Contact's first name
 * @method $this lastName($string)    (Optional). Contact's last name
 * @method $this vcard($string)       (Optional). Additional data about the contact in the form of a vCard, 0-2048 bytes
 */
class InputContactMessageContent extends InlineBaseObject
{
}
