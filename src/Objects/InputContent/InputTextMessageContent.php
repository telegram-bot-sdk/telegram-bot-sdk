<?php

namespace Telegram\Bot\Objects\InputContent;

use Telegram\Bot\Objects\Message\MessageEntity;

/**
 * Represents the content of a text message to be sent as the result of an inline query.
 *
 * @link https://core.telegram.org/bots/api#inputtextmessagecontent
 *
 * @method $this messageText(string $messageText) Required. Text of the message to be sent, 1-4096 characters.
 * @method $this parseMode(string $parseMode) (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in your bot's message.
 * @method $this entities(MessageEntity[] $messageEntity) (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this disableWebPagePreview(bool $disableWebPagePreview) (Optional). Disables link previews for links in the sent message
 */
final class InputTextMessageContent extends InputMessageContent {}
