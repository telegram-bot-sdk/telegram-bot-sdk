<?php

namespace Telegram\Bot;

/**
 * Class Actions.
 *
 * Chat Actions let you broadcast a type of action depending on what the user is about to receive.
 * The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing
 * status).
 */
final class Actions
{
    /** Sets chat status as Typing. */
    public const TYPING = 'typing';

    /** Sets chat status as Sending Photo. */
    public const UPLOAD_PHOTO = 'upload_photo';

    /** Sets chat status as Recording Video. */
    public const RECORD_VIDEO = 'record_video';

    /** Sets chat status as Sending Video. */
    public const UPLOAD_VIDEO = 'upload_video';

    /** Sets chat status as Recording Audio. */
    public const RECORD_AUDIO = 'record_audio';

    /** Sets chat status as Sending Audio. */
    public const UPLOAD_AUDIO = 'upload_audio';

    /** Sets chat status as Sending Document. */
    public const UPLOAD_DOCUMENT = 'upload_document';

    /** Sets chat status as Choosing Geo. */
    public const FIND_LOCATION = 'find_location';

    /** Sets chat status as Recording Video Note. */
    public const RECORD_VIDEO_NOTE = 'record_video_note';

    /** Sets chat status as Sending Video Note. */
    public const UPLOAD_VIDEO_NOTE = 'upload_video_note';
}
