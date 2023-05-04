<?php

namespace Telegram\Bot\Objects\InputContent;

/**
 * Represents the content of a contact message to be sent as the result of an inline query.
 *
 * @link https://core.telegram.org/bots/api#inputcontactmessagecontent
 *
 * @method $this phoneNumber(string $phoneNumber)   Required. Contact's phone number
 * @method $this firstName(string $firstName)       Required. Contact's first name
 * @method $this lastName(string $lastName)         (Optional). Contact's last name
 * @method $this vcard(string $vcard)               (Optional). Additional data about the contact in the form of a vCard, 0-2048 bytes
 */
final class InputContactMessageContent extends InputMessageContent
{
}
