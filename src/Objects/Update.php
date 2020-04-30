<?php

namespace Telegram\Bot\Objects;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Telegram\Bot\Exceptions\TelegramSDKException;
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
    protected string $updateType;
    protected string $entitiesKey;

    /**
     * @inheritdoc
     */
    public function relations(): array
    {
        return [
            'message'              => Message::class,
            'edited_message'       => EditedMessage::class,
            'channel_post'         => Message::class,
            'edited_channel_post'  => EditedMessage::class,
            'inline_query'         => InlineQuery::class,
            'chosen_inline_result' => ChosenInlineResult::class,
            'callback_query'       => CallbackQuery::class,
            'shipping_query'       => ShippingQuery::class,
            'pre_checkout_query'   => PreCheckoutQuery::class,
            'poll'                 => Poll::class,
            'poll_answer'          => PollAnswer::class,
        ];
    }

    /**
     * Determine if the update is of given type.
     *
     * @param string $type
     *
     * @return bool
     */
    public function isType($type): bool
    {
        if ($this->offsetExists($type)) {
            return true;
        }

        return $this->updateType() === $type;
    }

    /**
     * Update type.
     *
     * @return string
     */
    public function updateType(): string
    {
        return $this->updateType ??= $this->collect()
            ->except('update_id')
            ->keys()
            ->whenEmpty(static function () {
                throw TelegramSDKException::updateTypeIndeterminable();
            })
            ->first();
    }

    /**
     * Get the message contained in the Update.
     *
     * @return Message|EditedMessage|InlineQuery|ChosenInlineResult|CallbackQuery|ShippingQuery|PreCheckoutQuery|Poll|PollAnswer
     */
    public function getMessage()
    {
        return $this->{$this->updateType()};
    }

    public function getEventName(): string
    {
        return 'update.' . $this->updateType();
    }

    /**
     * Get chat object (if exists).
     */
    public function getChat()
    {
        return $this->getMessage()->get('chat');
    }

    /**
     * Is there a command entity in this update object.
     *
     * @return bool
     */
    public function hasCommand(): bool
    {
        return (bool)$this->getMessage()
            ->collect()
            ->filter(fn ($val, $field) => Str::endsWith($field, 'entities'))
            ->flatten()
            ->contains('type', 'bot_command');
    }

    public function getAllEntities(): ?array
    {
        return $this->getMessage()->{$this->getEntitiesKey()};
    }

    public function getCommandEntities(): ?Collection
    {
        return collect($this->getAllEntities())->filter(fn (MessageEntity $entity) => $entity->type === 'bot_command');
    }

    /**
     * Return the relevant text/string that the entities in the update are referencing.
     *
     * @return string|null
     */
    public function getEntitiesFullText(): ?string
    {
        if (!$this->getEntitiesKey()) {
            return null;
        }

        if ($this->getEntitiesKey() === 'entities') {
            return $this->getMessage()->text;
        }

        return $this->getMessage()->{Str::before($this->getEntitiesKey(), '_')};
    }

    protected function getEntitiesKey(): ?string
    {
        return $this->entitiesKey ??= $this->getMessage()
            ->collect()
            ->keys()
            ->first(fn ($key) => Str::contains($key, 'entities'));
    }
}
