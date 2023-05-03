<?php

namespace Telegram\Bot;

/**
 * Class EntityType.
 */
enum EntityType: string
{
    /** Sets MessageEntity Type as mention. */
    case MENTION = 'mention';

    /** Sets MessageEntity Type as hashtag . */
    case HASHTAG = 'hashtag';

    /** Sets MessageEntity Type as cashtag. */
    case CASHTAG = 'cashtag';

    /** Sets MessageEntity Type as Bot Command. */
    case BOT_COMMAND = 'bot_command';

    /** Sets MessageEntity Type as url. */
    case URL = 'url';

    /** Sets MessageEntity Type as email. */
    case EMAIL = 'email';

    /** Sets MessageEntity Type as phone number. */
    case PHONE_NUMBER = 'phone_number';

    /** Sets MessageEntity Type as bold. */
    case BOLD = 'bold';

    /** Sets MessageEntity Type as italic. */
    case ITALIC = 'italic';

    /** Sets MessageEntity Type as underline. */
    case UNDERLINE = 'underline';

    /** Sets MessageEntity Type as strike through. */
    case STRIKETHROUGH = 'strikethrough';

    /** Sets MessageEntity Type as spoiler . */
    case SPOILER = 'spoiler';

    /** Sets MessageEntity Type as code. */
    case CODE = 'code';

    /** Sets MessageEntity Type as pre. */
    case PRE = 'pre';

    /** Sets MessageEntity Type as text link. */
    case TEXT_LINK = 'text_link';

    /** Sets MessageEntity Type as text mention. */
    case TEXT_MENTION = 'text_mention';
}
