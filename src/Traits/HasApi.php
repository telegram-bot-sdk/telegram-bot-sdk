<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\Api;

/**
 * Class HasApi.
 */
trait HasApi
{
    /** @var Api|null Telegram Bot Api. */
    protected ?Api $api = null;

    /**
     * Determine if Telegram Bot Api is set.
     *
     * @return bool
     */
    public function hasApi(): bool
    {
        return $this->api !== null;
    }

    /**
     * Get the Telegram Bot Api.
     *
     * @return Api
     */
    public function getApi(): Api
    {
        return $this->api;
    }

    /**
     * Set the Telegram Bot Api.
     *
     * @param Api $api
     *
     * @return $this
     */
    public function setApi(Api $api): self
    {
        $this->api = $api;

        return $this;
    }
}
