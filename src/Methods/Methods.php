<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\BotCommandScope\BotCommandScope;
use Telegram\Bot\Objects\InputMedia\ArrayOfInputMedia;
use Telegram\Bot\Objects\InputMedia\InputMedia;
use Telegram\Bot\Objects\Keyboard\ForceReply;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\Keyboard\ReplyKeyboardMarkup;
use Telegram\Bot\Objects\Keyboard\ReplyKeyboardRemove;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\Http;

/**
 * @mixin Http
 */
trait Methods
{
    /**
     * A simple method for testing your bot's auth token.
     *
     * Returns basic information about the bot.
     *
     * @link https://core.telegram.org/bots/api#getme
     *
     * @return ResponseObject{
     * id : string,
     * is_bot : bool,
     * first_name : string,
     * last_name : string,
     * username : string,
     * language_code : string,
     * is_premium : bool,
     * added_to_attachment_menu : bool,
     * can_join_groups : bool,
     * can_read_all_group_messages : bool,
     * supports_inline_queries : bool,
     * }
     */
    public function getMe(): ResponseObject
    {
        return $this->get('getMe')->getResult();
    }

    /**
     * Use this method to log out from the cloud Bot API server before launching the bot locally.
     *
     * @link https://core.telegram.org/bots/api#logout
     */
    public function logOut(): bool
    {
        return $this->get('logout')->getResult();
    }

    /**
     * Use this method to close the bot instance before moving it from one local server to another.
     *
     * @link https://core.telegram.org/bots/api#logout
     */
    public function close(): bool
    {
        return $this->get('close')->getResult();
    }

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
     *
     * @return ResponseObject{
     *     message_id: int,
     *     message_thread_id : string,
     *     from: array {
     *      id: int,
     *      is_bot: bool,
     *      first_name: string,
     *      last_name: string,
     *      username: string,
     *      language_code: string,
     *      is_premium: bool,
     *      added_to_attachment_menu: bool,
     *      can_join_groups:bool,
     *      can_read_all_group_messages: bool,
     *      supports_inline_queries: bool
     *      },
     *     sender_chat: array,
     *     date: int,
     *     chat: array,
     *     forward_from_chat: array,
     *     forward_from_message_id: integer,
     *     forward_signature: string,
     *     forward_sender_name: string,
     *     forward_date: int,
     *     is_topic_message: bool,
     *     is_automatic_forward: bool,
     *     reply_to_message: array,
     *     via_bot: array,
     *     edit_date: int,
     *     has_protected_content: true,
     *     media_group_id: string,
     *     author_signature: string,
     *     text: string,
     *     entities: array<array{type:string, offset: int, length: int, url: string, user: array, language: string, custom_emoji_id: string}>,
     *     animation: array,
     *     audio: array,
     *     document: array,
     *     photo: array<array>,
     *     sticker: array,
     *     video: array,
     *     video_note: array,
     *     voice: array,
     *     caption: string,
     *     caption_entities: array<array{type:string, offset: int, length: int, url: string, user: array, language: string, custom_emoji_id: string}>,
     *     has_media_spoiler: bool,
     *     contact: array,
     *     dice: array,
     *     game: array,
     *     poll: array,
     *     venue: array,
     *     location: array,
     *     new_chat_members: array<array>,
     *     left_chat_member: array,
     *     new_chat_title: string,
     *     new_chat_photo: array<array>,
     *     delete_chat_photo: bool,
     *     group_chat_created: bool,
     *     supergroup_chat_created: bool,
     *     channel_chat_created: true,
     *     message_auto_delete_timer_changed: array,
     *     migrate_to_chat_id: int,
     *     migrate_from_chat_id: int,
     *     pinned_message: array,
     *     invoice: array,
     *     successful_payment: array,
     *     user_shared: array,
     *     chat_shared: array,
     *     connected_website: string,
     *     write_access_allowed: array,
     *     passport_data: array,
     *     proximity_alert_triggered: array,
     *     forum_topic_created: array,
     *     forum_topic_edited: array,
     *     forum_topic_closed: array,
     *     forum_topic_reopened: array,
     *     general_forum_topic_hidden: array,
     *     general_forum_topic_unhidden: array,
     *     video_chat_scheduled: array,
     *     video_chat_started: array,
     *     video_chat_ended: array,
     *     video_chat_participants_invited: array,
     *     web_app_data: array,
     *     reply_markup: InlineKeyboardMarkup
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
     *
     * @return ResponseObject{
     *     message_id: int
     * }
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
     *
     * @return ResponseObject<array>
     */
    public function sendMediaGroup(array $params): ResponseObject
    {
        if (array_key_exists('media', $params)) {
            $params['media'] = ArrayOfInputMedia::make($params['media']);
        }

        return $this->uploadFile('sendMediaGroup', $params)->getResult();
    }


    /**
     * Send point on the map.
     *
     * On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#sendlocation
     *
     * @param array{
     *   chat_id: int|string,
     *   message_thread_id: int,
     *   latitude: float,
     *   longitude: float,
     *   horizontal_accuracy: float,
     *   live_period: int,
     *   heading: int,
     *   proximity_alert_radius: int,
     *   disable_notification: bool,
     *   protect_content: bool,
     *   reply_to_message_id: int,
     *   allow_sending_without_reply: bool,
     *   reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     */
    public function sendLocation(array $params): ResponseObject
    {
        return $this->post('sendLocation', $params)->getResult();
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

    /**
     * Returns a list of profile pictures for a user.
     *
     * @link https://core.telegram.org/bots/api#getuserprofilephotos
     *
     * @param array{
     *    user_id: int,
     *    offset: int,
     *    limit: int,
     * } $params
     *
     * @return ResponseObject<array{
     *     total_count: int,
     *      photos: <array{
     *          file_id: string,
     *          file_unique_id: string,
     *          width: int,
     *          height: int,
     *          file_size: int
     *          }>
     * }>
     */
    public function getUserProfilePhotos(array $params): ResponseObject
    {
        return $this->get('getUserProfilePhotos', $params)->getResult();
    }

    /**
     * Returns basic info about a file and prepare it for downloading.
     *
     * Bots can download files of up to 20MB in size. On success, a File object
     * is returned. The file can then be downloaded via the link
     * https://api.telegram.org/file/bot< token >/< file_path >,
     * where < file_path > is taken from the response.
     *
     * It is guaranteed that the link will be valid for at least 1 hour.
     * When the link expires, a new one can be requested by calling getFile again
     *
     * @link https://core.telegram.org/bots/api#getfile
     *
     * @param array{
     *    file_id: string,
     * } $params
     *
     * @return ResponseObject{
     *     file_id: string,
     *     file_unique_id: string,
     *     file_size: int,
     *     file_path: string,
     * }
     */
    public function getFile(array $params): ResponseObject
    {
        return $this->get('getFile', $params)->getResult();
    }

    /**
     * Ban a user in a group, a supergroup or a channel
     *
     * In the case of supergroups, the user will not be able to return to the group on their own using
     * invite links etc., unless unbanned first.
     *
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#banchatmember
     *
     * @param array{
     *    chat_id: int|string,
     *    user_id: int,
     *    until_date: int,
     *    revoke_messages: bool,
     * } $params
     */
    public function banChatMember(array $params): bool
    {
        return $this->get('banChatMember', $params)->getResult();
    }

    /**
     * Unban a previously kicked user in a supergroup.
     *
     * The user will not return to the group automatically, but will be able to join via link, etc.
     *
     * The bot must be an administrator in the group for this to work. By default, this method guarantees that after the call the user is not a member of the chat, but will be able to join it. So if the user is a member of the chat they will also be removed from the chat. If you don't want this, use the parameter only_if_banned. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#unbanchatmember
     *
     * @param array{
     *    chat_id: int|string,
     *    user_id: int,
     *    only_if_banned: bool,
     * } $params
     */
    public function unbanChatMember(array $params): bool
    {
        return $this->get('unbanChatMember', $params)->getResult();
    }

    /**
     * Restrict a user in a supergroup.
     *
     * Pass True for all boolean parameters to lift restrictions from a user.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * @link https://core.telegram.org/bots/api#restrictchatmember
     *
     * @param array{
     *    chat_id: int|string,
     *    user_id: int,
     *  permissions: array{
     *    can_send_messages: bool,
     *    can_send_audios: bool,
     *    can_send_documents: bool,
     *    can_send_photos: bool,
     *    can_send_videos: bool,
     *    can_send_video_notes: bool,
     *    can_send_voice_notes: bool,
     *    can_send_polls: bool,
     *    can_send_other_messages: bool,
     *    can_add_web_page_previews: bool,
     *    can_change_info: bool,
     *    can_invite_users: bool,
     *    can_pin_messages: bool,
     *    can_manage_topics: bool,
     *     },
     *  use_independent_chat_permissions: bool,
     *    until_date: int,
     * } $params
     */
    public function restrictChatMember(array $params): bool
    {
        return $this->post('restrictChatMember', $params)->getResult();
    }

    /**
     * Promote or demote a user in a supergroup or a channel.
     *
     * Pass False for all boolean parameters to demote a user.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * @link https://core.telegram.org/bots/api#restrictchatmember
     *
     * @param array{
     *    chat_id: int|string,
     *    user_id: int,
     *    is_anonymous: bool,
     *    can_manage_chat: bool,
     *    can_post_messages: bool,
     *    can_edit_messages: bool,
     *    can_delete_messages: bool,
     *    can_manage_voice_chats: bool,
     *    can_restrict_members: bool,
     *    can_promote_members: bool,
     *  can_change_info: bool,
     *    can_invite_users: bool,
     *    can_pin_messages: bool,
     *  can_manage_topics: bool,
     * } $params
     */
    public function promoteChatMember(array $params): bool
    {
        return $this->post('promoteChatMember', $params)->getResult();
    }

    /**
     * Use this method to set a custom title for an administrator in a supergroup promoted by the bot.
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setchatadministratorcustomtitle
     *
     * @param array{
     *    chat_id: int|string,
     *    user_id: int,
     *    custom_title: string,
     * } $params
     */
    public function setChatAdministratorCustomTitle(array $params): bool
    {
        return $this->post('setChatAdministratorCustomTitle', $params)->getResult();
    }

    /**
     * Ban a channel chat in a supergroup or a channel. Until the chat is unbanned, the owner of the banned chat
     * won't be able to send messages on behalf of any of their channels.
     *
     * The bot must be an administrator in the supergroup or channel for this to work and must have the appropriate administrator rights.
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#banchatsenderchat
     *
     * @param array{
     *    chat_id: int|string,
     *    sender_chat_id: int,
     * } $params
     */
    public function banChatSenderChat(array $params): bool
    {
        return $this->post('banChatSenderChat', $params)->getResult();
    }

    /**
     * Unban a previously banned channel chat in a supergroup or channel.
     *
     * The bot must be an administrator for this to work
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#unbanchatsenderchat
     *
     * @param array{
     *    chat_id: int|string,
     *    sender_chat_id: int,
     * } $params
     */
    public function unbanChatSenderChat(array $params): bool
    {
        return $this->post('unbanChatSenderChat', $params)->getResult();
    }

    /**
     * Use this method to set default chat permissions for all members.
     * The bot must be an administrator in the group or a supergroup for this to work and
     * must have the can_restrict_members admin rights.
     *
     * @link https://core.telegram.org/bots/api#setchatpermissions
     *
     * @param array{
     *    chat_id: int|string,
     *    permissions: array{
     *    can_send_messages: bool,
     *    can_send_audios: bool,
     *    can_send_documents: bool,
     *    can_send_photos: bool,
     *    can_send_videos: bool,
     *    can_send_video_notes: bool,
     *    can_send_voice_notes: bool,
     *    can_send_polls: bool,
     *    can_send_other_messages: bool,
     *    can_add_web_page_previews: bool,
     *    can_change_info: bool,
     *    can_invite_users: bool,
     *    can_pin_messages: bool,
     *    can_manage_topics: bool,
     *     },
     *   use_independent_chat_permissions: bool,
     * } $params
     */
    public function setChatPermissions(array $params): bool
    {
        return $this->post('setChatPermissions', $params)->getResult();
    }

    /**
     * Generate a new primary invite link for a chat
     *
     * Any previously generated primary link is revoked. The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Returns the new invite link as String on success.
     *
     * @link https://core.telegram.org/bots/api#exportchatinvitelink
     *
     * @param array{
     *    chat_id: string|int,
     * } $params
     */
    public function exportChatInviteLink(array $params): string
    {
        return $this->post('exportChatInviteLink', $params)->getResult();
    }

    /**
     * Create an additional invite link for a chat
     *
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. The link can be revoked using the method revokeChatInviteLink. Returns the new invite link as ChatInviteLink object.
     *
     * @link https://core.telegram.org/bots/api#createchatinvitelink
     *
     * @param array{
     *    chat_id: string|int,
     *    name: string,
     *    expire_date: int,
     *    member_limit: int,
     *    creates_join_request: bool,
     * } $params
     *
     * @return ResponseObject{
     *     invite_link: string,
     *     creator: array,
     *     creates_join_request: bool,
     *     is_primary: bool,
     *     is_revoked: bool,
     *     name: string,
     *     expire_date: int,
     *     member_limit: int,
     *     pending_join_request_count: int,
     * }
     */
    public function createChatInviteLink(array $params): ResponseObject
    {
        return $this->post('createChatInviteLink', $params)->getResult();
    }

    /**
     * Edit a non-primary invite link created by the bot.
     *
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Returns the edited invite link as a ChatInviteLink object.
     *
     * @link https://core.telegram.org/bots/api#editchatinvitelink
     *
     * @param array{
     *    chat_id: string|int,
     *    invite_link: string,
     *    name: string,
     *    expire_date: int,
     *    member_limit: int,
     *    creates_join_request: bool,
     * } $params
     *
     * @return ResponseObject{
     *     invite_link: string,
     *     creator: array,
     *     creates_join_request: bool,
     *     is_primary: bool,
     *     is_revoked: bool,
     *     name: string,
     *     expire_date: int,
     *     member_limit: int,
     *     pending_join_request_count: int,
     * }
     */
    public function editChatInviteLink(array $params): ResponseObject
    {
        return $this->post('editChatInviteLink', $params)->getResult();
    }

    /**
     * Revoke an invite link created by the bot.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * @link https://core.telegram.org/bots/api#revokechatinvitelink
     *
     * @param array{
     *    chat_id: string|int,
     *    invite_link: string,
     * } $params
     *
     * @return ResponseObject{
     *     invite_link: string,
     *     creator: array,
     *     creates_join_request: bool,
     *     is_primary: bool,
     *     is_revoked: bool,
     *     name: string,
     *     expire_date: int,
     *     member_limit: int,
     *     pending_join_request_count: int,
     * }
     */
    public function revokeChatInviteLink(array $params): ResponseObject
    {
        return $this->post('revokeChatInviteLink', $params)->getResult();
    }

    /**
     * Approve a chat join request
     *
     * The bot must be an administrator in the chat for this to work and must have the can_invite_users administrator right. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#approvechatjoinrequest
     *
     * @param array{
     *    chat_id: string|int,
     *    user_id: int,
     * } $params
     */
    public function approveChatJoinRequest(array $params): bool
    {
        return $this->post('approveChatJoinRequest', $params)->getResult();
    }

    /**
     * Decline a chat join request
     *
     * The bot must be an administrator in the chat for this to work and must have the can_invite_users administrator right. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#declinechatjoinrequest
     *
     * @param array{
     *    chat_id: string|int,
     *    user_id: int,
     * } $params
     */
    public function declineChatJoinRequest(array $params): bool
    {
        return $this->post('declineChatJoinRequest', $params)->getResult();
    }

    /**
     * Set a new profile photo for the chat.
     *
     * Photos can't be changed for private chats. The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setchatphoto
     *
     * @param array{
     *    chat_id: string|int,
     *    photo: InputFile,
     * } $params
     */
    public function setChatPhoto(array $params): bool
    {
        return $this->uploadFile('setChatPhoto', $params)->getResult();
    }

    /**
     * Delete a chat photo.
     *
     * Photos can't be changed for private chats. The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#deletechatphoto
     *
     * @param array{
     *    chat_id: string|int,
     * } $params
     */
    public function deleteChatPhoto(array $params): bool
    {
        return $this->post('deleteChatPhoto', $params)->getResult();
    }

    /**
     * Set the title of a chat.
     *
     * Titles can't be changed for private chats. The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setchattitle
     *
     * @param array{
     *    chat_id: string|int,
     *    title: string,
     * } $params
     */
    public function setChatTitle(array $params): bool
    {
        return $this->post('setChatTitle', $params)->getResult();
    }

    /**
     * Set the description of a supergroup or a channel.
     *
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setchatdescription
     *
     * @param array{
     *    chat_id: string|int,
     *    description: string,
     * } $params
     */
    public function setChatDescription(array $params): bool
    {
        return $this->post('setChatDescription', $params)->getResult();
    }

    /**
     * Pin a message in a group, a supergroup, or a channel.
     *
     * If the chat is not a private chat, the bot must be an administrator in the chat for this to work and must have the 'can_pin_messages' administrator right in a supergroup or 'can_edit_messages' administrator right in a channel. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#pinchatmessage
     *
     * @param array{
     *    chat_id: string|int,
     *    message_id: int,
     *    disable_notification: bool,
     * } $params
     */
    public function pinChatMessage(array $params): bool
    {
        return $this->post('pinChatMessage', $params)->getResult();
    }

    /**
     * Unpin a message in a group, a supergroup, or a channel.
     *
     * If the chat is not a private chat, the bot must be an administrator in the chat for this to work and must have the 'can_pin_messages' administrator right in a supergroup or 'can_edit_messages' administrator right in a channel. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#unpinchatmessage
     *
     * @param array{
     *    chat_id: string|int,
     *    message_id: int,
     * } $params
     */
    public function unpinChatMessage(array $params): bool
    {
        return $this->post('unpinChatMessage', $params)->getResult();
    }

    /**
     * Unpin/clear the list of pinned messages in a chat.
     *
     * f the chat is not a private chat, the bot must be an administrator in the chat for this to work and must have the 'can_pin_messages' administrator right in a supergroup or 'can_edit_messages' administrator right in a channel. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#unpinallchatmessages
     *
     * @param array{
     *    chat_id: string|int,
     * } $params
     */
    public function unpinAllChatMessages(array $params): bool
    {
        return $this->post('unpinAllChatMessages', $params)->getResult();
    }

    /**
     * To leave a group, supergroup or channel.
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#leavechat
     *
     * @param array{
     *    chat_id: string|int,
     * } $params
     */
    public function leaveChat(array $params): bool
    {
        return $this->get('leaveChat', $params)->getResult();
    }

    /**
     * Get up to date information about the chat (current name of the user for one-on-one conversations,
     * current username of a user, group or channel, etc.).
     *
     * @link https://core.telegram.org/bots/api#getchat
     *
     * @param array{
     *    chat_id: string|int,
     * } $params
     */
    public function getChat(array $params): ResponseObject
    {
        return $this->get('getChat', $params)->getResult();
    }

    /**
     * Get a list of administrators in a chat.
     *
     * @link https://core.telegram.org/bots/api#getchatadministrators
     *
     * @param array{
     *    chat_id: string|int,
     * } $params
     *
     * @return ResponseObject<array>
     */
    public function getChatAdministrators(array $params): ResponseObject
    {
        return $this->get('getChatAdministrators', $params)->getResult();
    }

    /**
     * Get the number of members in a chat.
     *
     * @link https://core.telegram.org/bots/api#getchatmembercount
     *
     * @param array{
     *    chat_id: string|int,
     * } $params
     */
    public function getChatMemberCount(array $params): int
    {
        return $this->get('getChatMemberCount', $params)->getResult();
    }

    /**
     * Get information about a member of a chat.
     *
     * The method is only guaranteed to work for other users if the bot is an administrator in the chat. Returns a ChatMember object on success.
     *
     * @link https://core.telegram.org/bots/api#getchatmember
     *
     * @param array{
     *    chat_id: string|int,
     *    user_id: int,
     * } $params
     */
    public function getChatMember(array $params): ResponseObject
    {
        return $this->get('getChatMember', $params)->getResult();
    }

    /**
     * Set a new group sticker set for a supergroup.
     *
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Use the field can_set_sticker_set optionally returned in getChat requests to check if the bot can use this method. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setchatstickerset
     *
     * @param array{
     *    chat_id: string|int,
     *    sticker_set_name: string,
     * } $params
     */
    public function setChatStickerSet(array $params): bool
    {
        return $this->post('setChatStickerSet', $params)->getResult();
    }

    /**
     * Delete a group sticker set from a supergroup.
     *
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Use the field can_set_sticker_set optionally returned in getChat requests to check if the bot can use this method. Returns True on success
     *
     * @link https://core.telegram.org/bots/api#deletechatstickerset
     *
     * @param array{
     *    chat_id: string|int,
     * } $params
     */
    public function deleteChatStickerSet(array $params): bool
    {
        return $this->post('deleteChatStickerSet', $params)->getResult();
    }

    /**
     * Get custom emoji stickers
     *
     * can be used as a forum topic icon by any user. Requires no parameters. Returns an Array of Sticker objects
     *
     * @link https://core.telegram.org/bots/api#getforumtopiciconstickers
     *
     * @return ResponseObject<array>
     */
    public function getForumTopicIconStickers(): ResponseObject
    {
        return $this->get('getForumTopicIconStickers')->getResult();
    }

    /**
     * Create a topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights. Returns information about the created topic as a ForumTopic object.
     *
     * @link https://core.telegram.org/bots/api#createforumtopic
     *
     * @param array{
     *    chat_id: int|string,
     *    name: string,
     *    icon_color: int,
     *    icon_custom_emoji_id: string,
     * } $params
     *
     * @return ResponseObject{
     *     message_thread_id: int,
     *     name: string,
     *     icon_color: int,
     *     icon_custom_emoji_id: string
     * }
     */
    public function createForumTopic(array $params): ResponseObject
    {
        return $this->post('createForumTopic', $params)->getResult();
    }

    /**
     * Edit name and icon of a topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have can_manage_topics administrator rights, unless it is the creator of the topic. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#editforumtopic
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *  name: string,
     *    icon_custom_emoji_id: string,
     * } $params
     */
    public function editForumTopic(array $params): bool
    {
        return $this->post('editForumTopic', $params)->getResult();
    }

    /**
     * Close an open topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights, unless it is the creator of the topic. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#closeforumtopic
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     * } $params
     */
    public function closeForumTopic(array $params): bool
    {
        return $this->post('closeForumTopic', $params)->getResult();
    }

    /**
     * Reopen a closed topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights, unless it is the creator of the topic. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#reopenforumtopic
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     * } $params
     */
    public function reopenForumTopic(array $params): bool
    {
        return $this->post('reopenForumTopic', $params)->getResult();
    }

    /**
     * Delete a forum topic along with all its messages in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_delete_messages administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#deleteforumtopic
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     * } $params
     */
    public function deleteForumTopic(array $params): bool
    {
        return $this->post('deleteForumTopic', $params)->getResult();
    }

    /**
     * Clear the list of pinned messages in a forum topic.
     *
     * The bot must be an administrator in the chat for this to work and must have the can_pin_messages administrator right in the supergroup. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#unpinallforumtopicmessages
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     * } $params
     */
    public function unpinAllForumTopicMessages(array $params): bool
    {
        return $this->post('unpinAllForumTopicMessages', $params)->getResult();
    }

    /**
     * Edit the name of the 'General' topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have can_manage_topics administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#editgeneralforumtopic
     *
     * @param array{
     *    chat_id: int|string,
     *    name: string,
     * } $params
     */
    public function editGeneralForumTopic(array $params): bool
    {
        return $this->post('editGeneralForumTopic', $params)->getResult();
    }

    /**
     * Close an open 'General' topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#closegeneralforumtopic
     *
     * @param array{
     *    chat_id: int|string,
     * } $params
     */
    public function closeGeneralForumTopic(array $params): bool
    {
        return $this->post('closeGeneralForumTopic', $params)->getResult();
    }

    /**
     * Reopen a closed 'General' topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights. The topic will be automatically unhidden if it was hidden. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#reopengeneralforumtopic
     *
     * @param array{
     *    chat_id: int|string,
     * } $params
     */
    public function reopenGeneralForumTopic(array $params): bool
    {
        return $this->post('reopenGeneralForumTopic', $params)->getResult();
    }

    /**
     * Hide the 'General' topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights. The topic will be automatically closed if it was open. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#hidegeneralforumtopic
     *
     * @param array{
     *    chat_id: int|string,
     * } $params
     */
    public function hideGeneralForumTopic(array $params): bool
    {
        return $this->post('hideGeneralForumTopic', $params)->getResult();
    }

    /**
     * Unhide the 'General' topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#unhidegeneralforumtopic
     *
     * @param array{
     *    chat_id: int|string,
     * } $params
     */
    public function unhideGeneralForumTopic(array $params): bool
    {
        return $this->post('unhideGeneralForumTopic', $params)->getResult();
    }

    /**
     * Send answers to callback queries sent from inline keyboards
     *
     * The answer will be displayed to the user as a notification at the top of the chat screen or as an alert. On success, True is returned.
     *
     * @link https://core.telegram.org/bots/api#answercallbackquery
     *
     * @param array{
     *    callback_query_id: string,
     *    text: string,
     *    show_alert: bool,
     *    url: string,
     *    cache_time: int,
     * } $params
     */
    public function answerCallbackQuery(array $params): bool
    {
        return $this->post('answerCallbackQuery', $params)->getResult();
    }


    /**
     * Change the list of the bots commands.
     *
     * Returns True on success
     *
     * @link https://core.telegram.org/bots/api#setmycommands
     *
     * @param array{
     *    commands: array<int, array{command: string, description: string}>,
     *    scope: BotCommandScope[],
     *    language_code: String,
     * } $params
     */
    public function setMyCommands(array $params): bool
    {
        return $this->post('setMyCommands', $params)->getResult();
    }

    /**
     * Delete the list of the bot's commands for the given scope and user language
     *
     * After deletion, higher level commands will be shown to affected users. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#deletemycommands
     *
     * @param array{
     *    scope: BotCommandScope,
     *    language_code: String,
     * } $params
     */
    public function deleteMyCommands(array $params): bool
    {
        return $this->post('deleteMyCommands', $params)->getResult();
    }

    /**
     * Get the current list of the bot's commands for the given scope and user language
     *
     * Returns an Array of BotCommand objects. If commands aren't set, an empty list is returned
     *
     * @link https://core.telegram.org/bots/api#getmycommands
     *
     * @param array{
     *    scope: BotCommandScope,
     *    language_code: String,
     * } $params
     *
     * @return ResponseObject<array{command: string, description: string}>
     */
    public function getMyCommands(array $params = []): ResponseObject
    {
        return $this->get('getMyCommands', $params)->getResult();
    }

    /**
     * Change the bot's name
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setmyname
     *
     * @param array{
     *    name: string,
     *    language_code: string,
     * } $params
     */
    public function setMyName(array $params): ResponseObject
    {
        return $this->post('setMyName', $params)->getResult();
    }

    /**
     * Get the current bot name for the given user language.
     *
     * Returns BotName on success
     *
     * @link https://core.telegram.org/bots/api#getmyname
     *
     * @param array{
     *    language_code: string,
     * } $params
     *
     * @return ResponseObject{name: string}
     */
    public function getMyName(array $params = []): ResponseObject
    {
        return $this->get('getMyName', $params)->getResult();
    }

    /**
     * Change the bot's description
     *
     * Shown in the chat with the bot if the chat is empty. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setmydescription
     *
     * @param array{
     *    description: string,
     *    language_code: string,
     * } $params
     */
    public function setMyDescription(array $params): bool
    {
        return $this->post('setMyDescription', $params)->getResult();
    }

    /**
     * Get the current bot description for the given user language
     *
     * Returns BotDescription on success.
     *
     * @link https://core.telegram.org/bots/api#getmydescription
     *
     * @param array{
     *    language_code: string,
     * } $params
     *
     * @return ResponseObject{
     *  description: string
     * }
     */
    public function getMyDescription(array $params = []): ResponseObject
    {
        return $this->get('getMyDescription', $params)->getResult();
    }

    /**
     * Change the bot's short description
     *
     * Shown on the bot's profile page and is sent together with the link when users share the bot. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setmyshortdescription
     *
     * @param array{
     *    short_description: string,
     *    language_code: string,
     * } $params
     */
    public function setMyShortDescription(array $params): bool
    {
        return $this->post('setMyShortDescription', $params)->getResult();
    }

    /**
     * Get the current bot short description for the given user language
     *
     * Returns BotShortDescription on success.
     *
     * @link https://core.telegram.org/bots/api#getmydescription
     *
     * @param array{
     *    language_code: string,
     * } $params
     *
     * @return ResponseObject{
     *  short_description: string
     * }
     */
    public function getMyShortDescription(array $params): ResponseObject
    {
        return $this->get('getMyShortDescription', $params)->getResult();
    }

    /**
     * Change the bot's menu button in a private chat
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setchatmenubutton
     *
     * @param array{
     *    chat_id: int,
     *  menu_button: array
     * } $params
     */
    public function setChatMenuButton(array $params): bool
    {
        return $this->post('setChatMenuButton', $params)->getResult();
    }

    /**
     * Get the current value of the bot's menu button in a private chat, or the default menu button
     *
     * Returns MenuButton on success.
     *
     * @link https://core.telegram.org/bots/api#getchatmenubutton
     *
     * @param array{
     *    chat_id: int,
     * } $params
     */
    public function getChatMenuButton(array $params): bool
    {
        return $this->post('getChatMenuButton', $params)->getResult();
    }

    /**
     * Change the default administrator rights requested by the bot when it's added as an administrator to groups or channels
     *
     * These rights will be suggested to users, but they are free to modify the list before adding the bot. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setmydefaultadministratorrights
     *
     * @param array{
     *  rights: array,
     *    for_channels: bool,
     * } $params
     */
    public function setMyDefaultAdministratorRights(array $params): ResponseObject
    {
        return $this->post('setMyDefaultAdministratorRights', $params)->getResult();
    }

    /**
     * get the current default administrator rights of the bot
     *
     * Returns ChatAdministratorRights on success.
     *
     * @link https://core.telegram.org/bots/api#getmydefaultadministratorrights
     *
     * @param array{
     *    for_channels: bool,
     * } $params
     *
     * @return ResponseObject{
     *      is_anonymous: bool,
     *      can_manage_chat: bool,
     *      can_delete_messages: bool,
     *      can_manage_video_chats: bool,
     *      can_restrict_members: bool,
     *      can_promote_members: bool,
     *      can_change_info: bool,
     *      can_invite_users: bool,
     *      can_post_messages: bool,
     *      can_edit_messages: bool,
     *      can_pin_messages: bool,
     *      can_manage_topics: bool,
     *     }
     */
    public function getMyDefaultAdministratorRights(array $params): ResponseObject
    {
        return $this->post('getMyDefaultAdministratorRights', $params)->getResult();
    }
}