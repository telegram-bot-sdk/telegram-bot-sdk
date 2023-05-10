<?php

namespace Telegram\Bot\Enums;

/**
 * Parse Mode
 *
 * @link https://core.telegram.org/bots/api#formatting-options
 */
enum ParseMode: string
{
    case MARKDOWNV2 = 'MarkdownV2';
    case HTML = 'HTML';
    case MARKDOWN = 'Markdown';
}
