<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\Api;

/**
 * Class HasTelegram.
 */
trait HasTelegram
{
    /** @var Api Holds the Super Class Instance. */
    protected ?Api $telegram;

    /**
     * Returns Super Class Instance.
     *
     * @return Api
     */
    public function getTelegram(): Api
    {
        return $this->telegram;
    }

    /**
     * Set Telegram Api Instance.
     *
     * @param Api $telegram
     *
     * @return $this
     */
    public function setTelegram(Api $telegram): self
    {
        $this->telegram = $telegram;

        return $this;
    }

    /**
     * Determine Telegram Api instance has been set.
     *
     * @return bool
     */
    public function hasTelegram(): bool
    {
        return $this->telegram !== null;
    }
}
