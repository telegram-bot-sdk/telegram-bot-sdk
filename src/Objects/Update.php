<?php

namespace Telegram\Bot\Objects;

use Telegram\Bot\Objects\Updates\CallbackQuery;
use Telegram\Bot\Objects\Updates\ChatMemberUpdated;
use Telegram\Bot\Objects\Updates\ChosenInlineResult;
use Telegram\Bot\Objects\Updates\InlineQuery;
use Telegram\Bot\Objects\Updates\Message;
use Telegram\Bot\Objects\Updates\Poll;
use Telegram\Bot\Objects\Updates\PollAnswer;
use Telegram\Bot\Objects\Updates\PreCheckoutQuery;
use Telegram\Bot\Objects\Updates\ShippingQuery;

/**
 * Class Update.
 *
 * @link https://core.telegram.org/bots/api#update
 *
 * @property int                $update_id             The update's unique identifier. Update identifiers start from a certain positive number and increase sequentially.
 * @property Message            $message               (Optional). New incoming message of any kind - text, photo, sticker, etc.
 * @property Message            $edited_message        (Optional). New version of a message that is known to the bot and was edited.
 * @property Message            $channel_post          (Optional).(Optional). New incoming channel post of any kind — text, photo, sticker, etc.
 * @property Message            $edited_channel_post   (Optional). New version of a channel post that is known to the bot and was edited sticker, etc.
 * @property InlineQuery        $inline_query          (Optional). New incoming inline query.
 * @property ChosenInlineResult $chosen_inline_result  (Optional). A result of an inline query that was chosen by the user and sent to their chat partner.
 * @property CallbackQuery      $callback_query        (Optional). Incoming callback query.
 * @property ShippingQuery      $shipping_query        (Optional). New incoming shipping query. Only for invoices with flexible price
 * @property PreCheckoutQuery   $pre_checkout_query    (Optional). New incoming pre-checkout query. Contains full information about checkout
 * @property Poll               $poll                  (Optional). New poll state. Bots receive only updates about stopped polls and polls, which are sent by the bot
 * @property PollAnswer         $poll_answer           (Optional). A user changed their answer in a non-anonymous poll. Bots receive new votes only in polls that were sent by the bot itself.
 * @property ChatMemberUpdated  $my_chat_member        (Optional). The bot's chat member status was updated in a chat. For private chats, this update is received only when the bot is blocked or unblocked by the user.
 * @property ChatMemberUpdated  $chat_member           (Optional). A chat member's status was updated in a chat. The bot must be an administrator in the chat and must explicitly specify “chat_member” in the list of allowed_updates to receive these updates.
 *
 */
class Update extends AbstractResponseObject
{
    protected ?string $updateType = null;

    /**
     * @inheritdoc
     */
    public function relations(): array
    {
        return [
            'message'              => Message::class,
            'edited_message'       => Message::class,
            'channel_post'         => Message::class,
            'edited_channel_post'  => Message::class,
            'inline_query'         => InlineQuery::class,
            'chosen_inline_result' => ChosenInlineResult::class,
            'callback_query'       => CallbackQuery::class,
            'shipping_query'       => ShippingQuery::class,
            'pre_checkout_query'   => PreCheckoutQuery::class,
            'poll'                 => Poll::class,
            'poll_answer'          => PollAnswer::class,
            'my_chat_member'       => ChatMemberUpdated::class,
            'chat_member'          => ChatMemberUpdated::class,
        ];
    }

    /**
     * Update type.
     *
     * @return string|null
     */
    public function objectType(): ?string
    {
        return $this->updateType ??= $this->collect()
            ->except('update_id')
            ->keys()
            ->first();
    }

    /**
     * Get the message contained in the Update.
     *
     * @return Message|InlineQuery|ChosenInlineResult|CallbackQuery|ShippingQuery|PreCheckoutQuery|Poll|PollAnswer
     */
    public function getMessage()
    {
        return $this->{$this->objectType()};
    }

    /**
     * Get chat object (if exists).
     */
    public function getChat()
    {
        return $this->getMessage()->get('chat');
    }
}
