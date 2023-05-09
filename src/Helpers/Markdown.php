<?php

namespace Telegram\Bot\Helpers;

/**
 * MarkdownV2 style escaper.
 *
 * @link https://core.telegram.org/bots/api#markdownv2-style
 */
class Markdown
{
    public static function escape(string $text): string
    {
        $text = str_replace('\\', '\\\\', $text);

        return preg_replace('/([_*\[\]()~`>#+\-=|{}.!])/', '\\\\$1', $text);
    }
}
