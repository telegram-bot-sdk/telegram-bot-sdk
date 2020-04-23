<?php

namespace Telegram\Bot\Events;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Traits\HasApi;
use Telegram\Bot\Traits\HasUpdate;

/**
 * Class UpdateWasReceived.
 */
class UpdateWasReceived
{
    use HasApi;
    use HasUpdate;

    /**
     * UpdateWasReceived constructor.
     *
     * @param Update $update
     * @param Api    $api
     */
    public function __construct(Update $update, Api $api)
    {
        $this->setUpdate($update);
        $this->setApi($api);
    }
}
