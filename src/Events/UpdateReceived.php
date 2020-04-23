<?php

namespace Telegram\Bot\Events;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Traits\HasApi;
use Telegram\Bot\Traits\HasUpdate;

/**
 * Class UpdateReceived.
 */
class UpdateReceived
{
    use HasApi;
    use HasUpdate;

    /**
     * UpdateReceived constructor.
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
