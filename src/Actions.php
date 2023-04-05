<?php

namespace Telegram\Bot;

/**
 * Chat Actions.
 *
 * Chat Actions let you broadcast a type of action depending on what the user is about to receive.
 * The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing
 * status).
 */
enum Actions: string
{
    /** Sets chat status as Typing. */
    case TYPING = 'typing';
    /** Sets chat status as Sending Photo. */
    case UPLOAD_PHOTO = 'upload_photo';

    /** Sets chat status as Recording Video. */
    case RECORD_VIDEO = 'record_video';

    /** Sets chat status as Sending Video. */
    case UPLOAD_VIDEO = 'upload_video';

    /** Sets chat status as Recording Voice. */
    case RECORD_VOICE = 'record_voice';

    /** Sets chat status as Sending Voice. */
    case UPLOAD_VOICE = 'upload_voice';

    /** Sets chat status as Sending Document. */
    case UPLOAD_DOCUMENT = 'upload_document';

    /** Sets chat status as Choosing Sticker. */
    case CHOOSE_STICKER = 'choose_sticker';

    /** Sets chat status as Choosing Geo. */
    case FIND_LOCATION = 'find_location';

    /** Sets chat status as Recording Video Note. */
    case RECORD_VIDEO_NOTE = 'record_video_note';

    /** Sets chat status as Sending Video Note. */
    case UPLOAD_VIDEO_NOTE = 'upload_video_note';
}
