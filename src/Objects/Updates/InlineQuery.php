<?php

namespace Telegram\Bot\Objects\Updates;

use Telegram\Bot\Objects\AbstractResponseObject;
use Telegram\Bot\Objects\Location;
use Telegram\Bot\Objects\User;

/**
 * Class InlineQuery.
 *
 * @link https://core.telegram.org/bots/api#inlinequery
 *
 * @property int      $id        Unique identifier for this query.
 * @property User     $from      Sender.
 * @property string   $query     Text of the query.
 * @property string   $offset    Offset of the results to be returned.
 * @property string   $chat_type (Optional). Type of the chat, from which the inline query was sent. Can be either “sender” for a private chat with the inline query sender, “private”, “group”, “supergroup”, or “channel”. The chat type should be always known for requests sent from official clients and most third-party clients, unless the request was sent from a secret chat
 * @property Location $location  (Optional). Sender location, only for bots that request user location.
 */
class InlineQuery extends AbstractResponseObject
{
    /**
     * @return array{from: class-string<\Telegram\Bot\Objects\User>, location: class-string<\Telegram\Bot\Objects\Location>}
     */
    public function relations(): array
    {
        return [
            'from' => User::class,
            'location' => Location::class,
        ];
    }

    public function objectType(): ?string
    {
        return $this->findType(['location']);
    }
}
