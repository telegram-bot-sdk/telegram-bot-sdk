<?php

namespace Telegram\Bot\Objects\Updates;

use Telegram\Bot\Objects\AbstractResponseObject;
use Telegram\Bot\Objects\Animation;
use Telegram\Bot\Objects\Audio;
use Telegram\Bot\Objects\Chat;
use Telegram\Bot\Objects\Contact;
use Telegram\Bot\Objects\Dice;
use Telegram\Bot\Objects\Document;
use Telegram\Bot\Objects\Game;
use Telegram\Bot\Objects\Location;
use Telegram\Bot\Objects\MessageEntity;
use Telegram\Bot\Objects\Passport\PassportData;
use Telegram\Bot\Objects\Payments\Invoice;
use Telegram\Bot\Objects\Payments\SuccessfulPayment;
use Telegram\Bot\Objects\PhotoSize;
use Telegram\Bot\Objects\Sticker;
use Telegram\Bot\Objects\User;
use Telegram\Bot\Objects\Venue;
use Telegram\Bot\Objects\Video;
use Telegram\Bot\Objects\VideoNote;
use Telegram\Bot\Objects\Voice;

/**
 * Class Message.
 *
 * @link https://core.telegram.org/bots/api#message
 *
 * @property int               $message_id                Unique message identifier.
 * @property User              $from                      (Optional). Sender, can be empty for messages sent to channels.
 * @property int               $date                      Date the message was sent in Unix time.
 * @property Chat              $chat                      Conversation the message belongs to.
 * @property User              $forward_from              (Optional). For forwarded messages, sender of the original message.
 * @property Chat              $forward_from_chat         (Optional). For messages forwarded from a channel, information about the original channel.
 * @property int               $forward_from_message_id   (Optional). For forwarded channel posts, identifier of the original message in the channel.
 * @property string            $forward_signature         (Optional). For messages forwarded from channels, identifier of the original message in the channel
 * @property string            $forward_sender_name       (Optional). Sender's name for messages forwarded from users who disallow adding a link to their account in forwarded messages
 * @property int               $forward_date              (Optional). For forwarded messages, date the original message was sent in Unix time.
 * @property Message           $reply_to_message          (Optional). For replies, the original message. Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
 * @property User              $via_bot                   (Optional). Bot through which the message was sent
 * @property int               $edit_date                 (Optional). Date the message was last edited in Unix time.
 * @property string            $media_group_id            (Optional). The unique identifier of a media message group this message belongs to
 * @property string            $author_signature          (Optional). Signature of the post author for messages in channels
 * @property string            $text                      (Optional). For text messages, the actual UTF-8 text of the message, 0-4096 characters.
 * @property MessageEntity[]   $entities                  (Optional). For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text.
 * @property MessageEntity[]   $caption_entities          (Optional). For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption.
 * @property Audio             $audio                     (Optional). Message is an audio file, information about the file.
 * @property Document          $document                  (Optional). Message is a general file, information about the file.
 * @property Animation         $animation                 (Optional). Message is an animation, information about the animation. For backward compatibility, when this field is set, the document field will also be set
 * @property Game              $game                      (Optional). Message is a game, information about the game.
 * @property PhotoSize[]       $photo                     (Optional). Message is a photo, available sizes of the photo.
 * @property Sticker           $sticker                   (Optional). Message is a sticker, information about the sticker.
 * @property Video             $video                     (Optional). Message is a video, information about the video.
 * @property Voice             $voice                     (Optional). Message is a voice message, information about the file.
 * @property VideoNote         $video_note                (Optional). Message is a video note, information about the video message.
 * @property string            $caption                   (Optional). Caption for the document, photo or video, 0-200 characters.
 * @property Contact           $contact                   (Optional). Message is a shared contact, information about the contact.
 * @property Location          $location                  (Optional). Message is a shared location, information about the location.
 * @property Venue             $venue                     (Optional). Message is a venue, information about the venue.
 * @property Poll              $poll                      (Optional). Message is a native poll, information about the poll
 * @property User[]            $new_chat_members          (Optional). New members that were added to the group or supergroup and information about them (the bot itself may be one of these members).
 * @property User              $left_chat_member          (Optional). A member was removed from the group, information about them (this member may be the bot itself).
 * @property string            $new_chat_title            (Optional). A chat title was changed to this value.
 * @property PhotoSize[]       $new_chat_photo            (Optional). A chat photo was change to this value.
 * @property bool              $delete_chat_photo         (Optional). Service message: the chat photo was deleted.
 * @property bool              $group_chat_created        (Optional). Service message: the group has been created.
 * @property bool              $supergroup_chat_created   (Optional). Service message: the super group has been created.
 * @property bool              $channel_chat_created      (Optional). Service message: the channel has been created.
 * @property int               $migrate_to_chat_id        (Optional). The group has been migrated to a supergroup with the specified identifier, not exceeding 1e13 by absolute value.
 * @property int               $migrate_from_chat_id      (Optional). The supergroup has been migrated from a group with the specified identifier, not exceeding 1e13 by absolute value.
 * @property Message           $pinned_message            (Optional). Specified message was pinned. Note that the Message object in this field will not contain further reply_to_message fields even if it is itself a reply.
 * @property Invoice           $invoice                   (Optional). Message is an invoice for a payment, information about the invoice.
 * @property SuccessfulPayment $successful_payment        (Optional). Message is a service message about a successful payment, information about the payment.
 * @property string            $connected_website         (Optional). The domain name of the website on which the user has logged in.
 * @property PassportData      $passport_data             (Optional). Telegram Passport data
 * @property string            $reply_markup              (Optional). Inline keyboard attached to the message. login_url buttons are represented as ordinary url buttons.
 */
class Message extends AbstractResponseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [
            'from'               => User::class,
            'chat'               => Chat::class,
            'forward_from'       => User::class,
            'forward_from_chat'  => Chat::class,
            'reply_to_message'   => self::class,
            'via_bot'            => User::class,
            'entities'           => MessageEntity::class,
            'caption_entities'   => MessageEntity::class,
            'audio'              => Audio::class,
            'document'           => Document::class,
            'animation'          => Animation::class,
            'game'               => Game::class,
            'photo'              => PhotoSize::class,
            'sticker'            => Sticker::class,
            'video'              => Video::class,
            'voice'              => Voice::class,
            'video_note'         => VideoNote::class,
            'contact'            => Contact::class,
            'location'           => Location::class,
            'venue'              => Venue::class,
            'poll'               => Poll::class,
            'dice'               => Dice::class,
            'new_chat_members'   => User::class,
            'left_chat_member'   => User::class,
            'new_chat_photo'     => PhotoSize::class,
            'pinned_message'     => self::class,
            'invoice'            => Invoice::class,
            'successful_payment' => SuccessfulPayment::class,
            'passport_data'      => PassportData::class,
        ];
    }

    /**
     * Detect type based on properties.
     *
     * @return string|null
     */
    public function objectType(): ?string
    {
        $types = [
            'text',
            'audio',
            'document',
            'animation',
            'game',
            'photo',
            'sticker',
            'video',
            'voice',
            'video_note',
            'contact',
            'location',
            'venue',
            'poll',
            'dice',
            'new_chat_members',
            'left_chat_member',
            'new_chat_title',
            'new_chat_photo',
            'delete_chat_photo',
            'group_chat_created',
            'supergroup_chat_created',
            'channel_chat_created',
            'migrate_to_chat_id',
            'migrate_from_chat_id',
            'pinned_message',
            'invoice',
            'successful_payment',
            'passport_data',
        ];

        return $this->findType($types);
    }
}
