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
 * @property Location $location  (Optional). Sender location, only for bots that request user location.
 * @property string   $query     Text of the query.
 * @property string   $offset    Offset of the results to be returned.
 */
class InlineQuery extends AbstractResponseObject
{
    public function relations(): array
    {
        return [
            'from'     => User::class,
            'location' => Location::class,
        ];
    }

    public function objectType(): ?string
    {
        return $this->findType(['location']);
    }
}
