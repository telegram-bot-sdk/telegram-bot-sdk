<?php

namespace Telegram\Bot\Objects;

/**
 * Class Location.
 *
 * @link https://core.telegram.org/bots/api#location
 *
 * @property float $longitude  Longitude as defined by sender.
 * @property float $latitude   Latitude as defined by sender.
 */
class Location extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [];
    }
}
