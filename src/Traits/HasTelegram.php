<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\Api;

/**
 * Class HasTelegram.
 */
trait HasTelegram
{
    /** @var Api|null Telegram Api. */
    protected ?Api $telegram = null;

    /**
     * Determine if Telegram Api is set.
     *
     * @return bool
     */
    public function hasTelegram(): bool
    {
        return $this->telegram !== null;
    }

    /**
     * Get the Telegram Api.
     *
     * @return Api
     */
    public function getTelegram(): Api
    {
        return $this->telegram;
    }

    /**
     * Set the Telegram Api.
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
}
