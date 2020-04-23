<?php

namespace Telegram\Bot\Objects;

use Illuminate\Support\Str;
use Telegram\Bot\Objects\Payments\PreCheckoutQuery;
use Telegram\Bot\Objects\Payments\ShippingQuery;

/**
 * Class Update.
 *
 * @link https://core.telegram.org/bots/api#update
 *
 * @property int                $update_id             The update's unique identifier. Update identifiers start from a certain positive number and increase sequentially.
 * @property Message            $message               (Optional). New incoming message of any kind - text, photo, sticker, etc.
 * @property EditedMessage      $edited_message        (Optional). New version of a message that is known to the bot and was edited.
 * @property Message            $channel_post          (Optional).(Optional). New incoming channel post of any kind — text, photo, sticker, etc.
 * @property EditedMessage      $edited_channel_post   (Optional). New version of a channel post that is known to the bot and was edited sticker, etc.
 * @property InlineQuery        $inline_query          (Optional). New incoming inline query.
 * @property ChosenInlineResult $chosen_inline_result  (Optional). A result of an inline query that was chosen by the user and sent to their chat partner.
 * @property CallbackQuery      $callback_query        (Optional). Incoming callback query.
 * @property ShippingQuery      $shipping_query        (Optional). New incoming shipping query. Only for invoices with flexible price
 * @property PreCheckoutQuery   $pre_checkout_query    (Optional). New incoming pre-checkout query. Contains full information about checkout
 * @property Poll               $poll                  (Optional). New poll state. Bots receive only updates about stopped polls and polls, which are sent by the bot
 * @property PollAnswer         $poll_answer           (Optional). A user changed their answer in a non-anonymous poll. Bots receive new votes only in polls that were sent by the bot itself.
 *
 */
class Update extends BaseObject
{
    /**
     * Determine if the update is of given type.
     *
     * @param string $type
     *
     * @return bool
     */
    public function isType($type): bool
    {
        $type = Str::lower($type);

        if ($this->has($type)) {
            return true;
        }

        return $this->detectType() === $type;
    }

    /**
     * Detect type based on properties.
     *
     * @return string|null
     */
    public function detectType(): ?string
    {
        $types = [
            'message',
            'edited_message',
            'channel_post',
            'edited_channel_post',
            'inline_query',
            'chosen_inline_result',
            'callback_query',
            'shipping_query',
            'pre_checkout_query',
            'poll',
            'poll_answer',
        ];

        return $this->collect()
            ->keys()
            ->intersect($types)
            ->pop();
    }

    /**
     * Get the message contained in the Update.
     */
    public function getMessage()
    {
        switch ($this->detectType()) {
            case 'message':
                return $this->message;
            case 'edited_message':
                return $this->edited_message;
            case 'channel_post':
                return $this->channel_post;
            case 'edited_channel_post':
                return $this->edited_channel_post;
            case 'inline_query':
                return $this->inline_query;
            case 'chosen_inline_result':
                return $this->chosen_inline_result;
            case 'callback_query':
                if (isset($this->callback_query->message)) {
                    return $this->callback_query->message;
                }
                break;
            case 'shipping_query':
                return $this->shipping_query;
            case 'pre_checkout_query':
                return $this->pre_checkout_query;
            case 'poll':
                return $this->poll;
            case 'poll_answer':
                return $this->poll_answer;
        }

        return $this;
    }

    /**
     * Get chat object (if exists).
     */
    public function getChat()
    {
        $message = $this->getMessage();

        return $message->chat ?? collect();
    }

    /**
     * Is there a command entity in this update object.
     *
     * @return bool
     */
    public function hasCommand(): bool
    {
        $message = collect($this->getMessage());

        return (bool)collect($message->get('entities'))->contains('type', 'bot_command');
    }
}
