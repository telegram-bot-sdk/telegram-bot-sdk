<?php

namespace Telegram\Bot\Objects\Message;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * Represents one special entity in a text message. For example, hashtags, usernames, URLs, etc
 *
 * @link https://core.telegram.org/bots/api#messageentity
 *
 * @method $this type(string $text)                Type of the entity. Currently, can be “mention” (@username), “hashtag” (#hashtag), “cashtag” ($USD), “bot_command” (/start@jobs_bot), “url” (https://telegram.org), “email” (do-not-reply@telegram.org), “phone_number” (+1-212-555-0123), “bold” (bold text), “italic” (italic text), “underline” (underlined text), “strikethrough” (strikethrough text), “spoiler” (spoiler message), “code” (monowidth string), “pre” (monowidth block), “text_link” (for clickable text URLs), “text_mention” (for users without usernames), “custom_emoji” (for inline custom emoji stickers)
 * @method $this offset(int $offset)               Offset in UTF-16 code units to the start of the entity
 * @method $this length(int $length)               Length of the entity in UTF-16 code units
 * @method $this url(string $url)                  Optional. For “text_link” only, URL that will be opened after user taps on the text
 * @method $this user($user)                       Optional. For “text_mention” only, the mentioned user
 * @method $this language(string $language)        Optional. For “pre” only, the programming language of the entity text
 * @method $this customEmojiId(string $emojiId)    Optional. For “custom_emoji” only, unique identifier of the custom emoji. Use getCustomEmojiStickers to get full information about the sticker                                       (Optional). If specified, the described Web App will be launched when the button is pressed. The Web App will be able to send a “web_app_data” service message. Available in private chats only.
 */
final class MessageEntity extends AbstractCreateObject
{
}
