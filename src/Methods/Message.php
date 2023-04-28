<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\InputMedia\ArrayOfInputMedia;
use Telegram\Bot\Objects\InputMedia\InputMedia;
use Telegram\Bot\Objects\Keyboard\ForceReply;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\Keyboard\ReplyKeyboardMarkup;
use Telegram\Bot\Objects\Keyboard\ReplyKeyboardRemove;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\Http;

/**
 * Class Message.
 *
 * @mixin Http
 */
trait Message
{
    /**
     * Send text messages.
     *
     * @link https://core.telegram.org/bots/api#sendmessage
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    text: string,
     *    parse_mode: string,
     *    entities: array,
     *    disable_web_page_preview: bool,
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     *    reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     * @return ResponseObject{
     *     message_id: int,
     *     message_thread_id : string,
     *     new: string,
     *     from: array {
     *      id: int
     *      },
     *     sender_chat: array,
     *     date: int,
     *     chat: chat,
     *     forward_from_chat: chat,
     *     forward_from_message_id: integer,
     *     forward_signature:
     * }
     */
    public function sendMessage(array $params): ResponseObject
    {
        return $this->post('sendMessage', $params)->getResult();
    }

    /**
     * Forward messages of any kind.
     *
     * Service messages can't be forwarded. On success, the sent Message is returned
     *
     * @link https://core.telegram.org/bots/api#forwardmessage
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    from_chat_id: int|string,
     *    disable_notification: bool,
     *    protect_content: bool ,
     *    message_id: int,
     * } $params
     */
    public function forwardMessage(array $params): ResponseObject
    {
        return $this->post('forwardMessage', $params)->getResult();
    }

    /**
     * Copy messages of any kind. Service messages and invoice messages can't be copied. A quiz poll can be copied only if the value of the field correct_option_id is known to the bot. The method is analogous to the method forwardMessage, but the copied message doesn't have a link to the original message.
     *
     * Returns the MessageId of the sent message on success.
     *
     * @link https://core.telegram.org/bots/api#copymessage
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    from_chat_id: int|string,
     *    message_id: int,
     *    caption: string,
     *    parse_mode: string,
     *    caption_entities: array,
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     *    reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     */
    public function copyMessage(array $params): ResponseObject
    {
        return $this->post('copyMessage', $params)->getResult();
    }

    /**
     * Send Photo.
     *
     * On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#sendphoto
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    photo: InputFile|string,
     *    caption: string,
     *    parse_mode: string,
     *    caption_entities: array,
     *    has_spoiler: bool,
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     *    reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     */
    public function sendPhoto(array $params): ResponseObject
    {
        return $this->uploadFile('sendPhoto', $params)->getResult();
    }

    /**
     * Send audio files.
     *
     * If you want Telegram clients to display them in the music player. Your audio must be in the .MP3 or .M4A format. On success, the sent Message is returned. Bots can currently send audio files of up to 50 MB in size, this limit may be changed in the future
     *
     * @link https://core.telegram.org/bots/api#sendaudio
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    audio: InputFile|string,
     *    caption: string,
     *    parse_mode: string,
     *    caption_entities: array,
     *    duration: int,
     *    performer: string,
     *    title: string,
     *    thumbnail: InputFile|string,
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     *    reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     */
    public function sendAudio(array $params): ResponseObject
    {
        return $this->uploadFile('sendAudio', $params)->getResult();
    }

    /**
     * Send general files.
     *
     * On success, the sent Message is returned. Bots can currently send files of any type of up to 50 MB in size, this limit may be changed in the future.
     *
     * @link https://core.telegram.org/bots/api#senddocument
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    document: InputFile|string,
     *    thumbnail: InputFile|string,
     *    caption: string,
     *    parse_mode: string,
     *    disable_content_type_detection: bool,
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     *    reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     */
    public function sendDocument(array $params): ResponseObject
    {
        return $this->uploadFile('sendDocument', $params)->getResult();
    }

    /**
     * Send Video File
     *
     * Telegram clients support MPEG4 videos (other formats may be sent as Document). On success, the sent Message is returned. Bots can currently send video files of up to 50 MB in size, this limit may be changed in the future.
     *
     * @link https://core.telegram.org/bots/api#sendvideo
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    video: InputFile|string,
     *    duration: int,
     *    width: int,
     *    height: int,
     *    thumbnail: InputFile|string,
     *    caption: string,
     *    parse_mode: string,
     *    caption_entities: array,
     *    supports_streaming: bool,
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     *    reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     *
     * @see  sendDocument
     */
    public function sendVideo(array $params): ResponseObject
    {
        return $this->uploadFile('sendVideo', $params)->getResult();
    }

    /**
     * Send animation files (GIF or H.264/MPEG-4 AVC video without sound).
     *
     * On success, the sent Message is returned. Bots can currently send animation files of up to 50 MB in size, this limit may be changed in the future.
     *
     * @link https://core.telegram.org/bots/api#sendanimation
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    animation: InputFile|string,
     *    duration: int,
     *    width: int,
     *    height: int,
     *    thumbnail: InputFile|string,
     *    caption: string,
     *    parse_mode: string,
     *    caption_entities: array,
     *    has_spoiler: bool,
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     *    reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     */
    public function sendAnimation(array $params): ResponseObject
    {
        return $this->uploadFile('sendAnimation', $params)->getResult();
    }

    /**
     * Send voice audio files.
     *
     * if you want Telegram clients to display the file as a playable voice message. For this to work, your audio must be in an .OGG file encoded with OPUS (other formats may be sent as Audio or Document). On success, the sent Message is returned. Bots can currently send voice messages of up to 50 MB in size, this limit may be changed in the future.
     *
     * @link https://core.telegram.org/bots/api#sendvoice
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    voice: InputFile|string,
     *    caption: string,
     *    parse_mode: string,
     *    caption_entities: array,
     *    duration: int,
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     *    reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     */
    public function sendVoice(array $params): ResponseObject
    {
        return $this->uploadFile('sendVoice', $params)->getResult();
    }

    /**
     * Send rounded square mp4 videos of up to 1 minute long.
     *
     * Use this method to send video messages. On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#sendvideonote
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    video_note: InputFile|string,
     *    duration: int,
     *    length: int,
     *    thumbnail: InputFile|string,
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     *    reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     */
    public function sendVideoNote(array $params): ResponseObject
    {
        return $this->uploadFile('sendVideoNote', $params)->getResult();
    }

    /**
     * Send a group of photos, audio, documents or videos as an album.
     *
     * Documents and audio files can be only grouped in an album with messages of the same type. On success, an array of Messages that were sent is returned.
     *
     * @link https://core.telegram.org/bots/api#sendmediagroup
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    media: InputMedia[],
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     * } $params
     * @return ResponseObject[]
     */
    public function sendMediaGroup(array $params): array
    {
        if (array_key_exists('media', $params)) {
            $params['media'] = ArrayOfInputMedia::make($params['media']);
        }

        return $this->uploadFile('sendMediaGroup', $params)->getResult();
    }

    /**
     * Send information about a venue.
     *
     * On success, the sent Message is returned
     *
     * @link https://core.telegram.org/bots/api#sendvenue
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    latitude: float,
     *    longitude: float,
     *    title: string,
     *    address: string,
     *    foursquare_id: string,
     *    foursquare_type: string,
     *    google_place_id: string,
     *    google_place_type: string,
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     *    reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     */
    public function sendVenue(array $params): ResponseObject
    {
        return $this->post('sendVenue', $params)->getResult();
    }

    /**
     * Send phone contacts.
     *
     * @link https://core.telegram.org/bots/api#sendcontact
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    phone_number: string,
     *    first_name: string,
     *    last_name: string,
     *    vcard: string,
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     *    reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     */
    public function sendContact(array $params): ResponseObject
    {
        return $this->post('sendContact', $params)->getResult();
    }

    /**
     * Send a poll.
     *
     * Use this method to send a native poll. On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#sendpoll
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    question: string,
     *    options: array,
     *    is_anonymous: bool,
     *    type: string,
     *    allows_multiple_answers: bool,
     *    correct_option_id: int,
     *    explanation: string,
     *    explanation_parse_mode: string,
     *    explanation_entities: array,
     *    open_period: int,
     *    close_date: int,
     *    is_closed: bool,
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     *    reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     */
    public function sendPoll(array $params): ResponseObject
    {
        return $this->post('sendPoll', $params)->getResult();
    }

    /**
     * Send a die.
     *
     * Use this method to send an animated emoji that will display a random value. On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#senddice
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    emoji: string,
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     *    reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     */
    public function sendDice(array $params): ResponseObject
    {
        return $this->post('sendDice', $params)->getResult();
    }

    /**
     * Broadcast a Chat Action.
     *
     * Tell the user that something is happening on the bots side. The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing status). Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#sendchataction
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    action: string,
     * } $params
     */
    public function sendChatAction(array $params): bool
    {
        return $this->post('sendChatAction', $params)->getResult();
    }
}
