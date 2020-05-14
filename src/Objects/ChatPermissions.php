<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatPermissions.
 *
 * @link https://core.telegram.org/bots/api#chatpermissions
 *
 * @property bool $can_send_messages          (Optional). True, if the user is allowed to send text messages, contacts, locations and venues
 * @property bool $can_send_media_messages    (Optional). True, if the user is allowed to send audios, documents, photos, videos, video notes and voice notes, implies can_send_messages
 * @property bool $can_send_polls             (Optional). True, if the user is allowed to send polls, implies can_send_messages
 * @property bool $can_send_other_messages    (Optional). True, if the user is allowed to send animations, games, stickers and use inline bots, implies can_send_media_messages
 * @property bool $can_add_web_page_previews  (Optional). True, if the user is allowed to add web page previews to their messages, implies can_send_media_messages
 * @property bool $can_change_info            (Optional). True, if the user is allowed to change the chat title, photo and other settings. Ignored in public supergroups
 * @property bool $can_invite_users           (Optional). True, if the user is allowed to invite new users to the chat
 * @property bool $can_pin_messages           (Optional). True, if the user is allowed to pin messages. Ignored in public supergroups
 */
class ChatPermissions extends AbstractObject
{
}
