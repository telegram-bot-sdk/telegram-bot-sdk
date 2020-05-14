<?php

namespace Telegram\Bot\Objects;

/**
 * Class Contact.
 *
 * @link https://core.telegram.org/bots/api#contact
 *
 * @property string $phone_number  Contact's phone number.
 * @property string $first_name    Contact's first name.
 * @property string $last_name     (Optional). Contact's last name.
 * @property int    $user_id       (Optional). Contact's user identifier in Telegram.
 * @property string $vcard         (Optional). Additional data about the contact in the form of a vCard.
 */
class Contact extends AbstractObject
{
}
