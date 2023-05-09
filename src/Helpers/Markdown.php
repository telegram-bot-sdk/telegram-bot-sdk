<?php

namespace Telegram\Bot\Helpers;

/**
 * MarkdownV2 style escaper and syntax helpers.
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

    /**
     * Handle ambiguity between italic and underline entities.
     */
    public static function escapeItalicUnderline(string $text): string
    {
        return preg_replace('/(___)(.*?)(___)/', '$1$2_\\\\r__', $text);
    }

    public static function bold(string $text): string
    {
        return '*'.self::escape($text).'*';
    }

    public static function italic(string $text): string
    {
        return '_'.self::escape($text).'_';
    }

    public static function underline(string $text): string
    {
        return '__'.self::escape($text).'__';
    }

    public static function strike(string $text): string
    {
        return '~'.self::escape($text).'~';
    }

    public static function spoiler(string $text): string
    {
        return '||'.self::escape($text).'||';
    }

    public static function url(string $text, string $url): string
    {
        return '['.self::escape($text).']('.self::escape($url).')';
    }

    public static function emoji(string $emoji, int|string $id): string
    {
        return '!'.self::url($emoji, 'tg://emoji?id='.$id);
    }

    public static function mention(string $name, int|string $id): string
    {
        return self::url($name, 'tg://user?id='.$id);
    }

    public static function pre(string $text): string
    {
        return self::code($text);
    }

    public static function code(string $code, ?string $language = null): string
    {
        $str = '```';
        if ($language !== null) {
            $str .= self::escape($language);
        }

        return $str."\n".self::escape($code)."\n".'```';
    }

    public static function inlineCode(string $text): string
    {
        return '`'.self::escape($text).'`';
    }

    public static function list(array $items, bool $ordered = false): string
    {
        $list = '';
        foreach ($items as $index => $item) {
            if ($ordered) {
                $list .= ($index + 1).'\\. ';
            } else {
                $list .= '\\- ';
            }
            $list .= self::escape($item)."\n";
        }

        return $list;
    }
}
