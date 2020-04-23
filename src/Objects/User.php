<?php

namespace Telegram\Bot\Objects;

/**
 * Class User.
 *
 * @link https://core.telegram.org/bots/api#user
 *
 * @property int    $id                           Unique identifier for this user or bot.
 * @property bool   $is_bot                       True, if this user is a bot
 * @property string $first_name                   User's or bot's first name.
 * @property string $last_name                    (Optional). User's or bot's last name.
 * @property string $username                     (Optional). User's or bot's username.
 * @property string $language_code                (Optional). IETF language tag of the user's language
 * @property bool   $can_join_groups              (Optional). True, if the bot can be invited to groups. Returned only in getMe.
 * @property bool   $can_read_all_group_messages  (Optional). True, if privacy mode is disabled for the bot. Returned only in getMe.
 * @property bool   $supports_inline_queries      (Optional). True, if the bot supports inline queries. Returned only in getMe.
 */
class User
{
}
