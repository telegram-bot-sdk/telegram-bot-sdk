<?php

namespace Telegram\Bot\Helpers;

/**
 * MarkdownV2 style escaper.
 *
 * @link https://core.telegram.org/bots/api#markdownv2-style
 */
final class Markdown
{
    private const SPECIAL_CHARS = [
        '\\', '_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!',
    ];

    private const ESCAPED_SPECIAL_CHARS = [
        '\\\\', '\\_', '\\*', '\\[', '\\]', '\\(', '\\)', '\\~', '\\`', '\\>', '\\#', '\\+', '\\-', '\\=', '\\|', '\\{', '\\}', '\\.', '\\!',
    ];

    public static function escape(string $text): string
    {
        return str_replace(self::SPECIAL_CHARS, self::ESCAPED_SPECIAL_CHARS, $text);
    }
}
