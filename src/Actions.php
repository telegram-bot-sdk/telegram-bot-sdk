<?php

namespace Telegram\Bot;

/**
 * Chat Actions.
 *
 * Chat Actions let you broadcast a type of action depending on what the user is about to receive.
 * The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing
 * status).
 *
 * @link https://core.telegram.org/bots/api#sendchataction
 */
enum Actions: string
{
    case TYPING = 'typing';
    case UPLOAD_PHOTO = 'upload_photo';
    case RECORD_VIDEO = 'record_video';
    case UPLOAD_VIDEO = 'upload_video';
    case RECORD_VOICE = 'record_voice';
    case UPLOAD_VOICE = 'upload_voice';
    case UPLOAD_DOCUMENT = 'upload_document';
    case CHOOSE_STICKER = 'choose_sticker';
    case FIND_LOCATION = 'find_location';
    case RECORD_VIDEO_NOTE = 'record_video_note';
    case UPLOAD_VIDEO_NOTE = 'upload_video_note';
}
