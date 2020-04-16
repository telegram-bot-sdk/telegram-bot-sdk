<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\Objects\Update;

/**
 * HasTelegramUpdate.
 */
trait HasUpdate
{
    /** @var Update Holds Telegram Update */
    protected Update $update;

    /**
     * Set Telegram Update.
     *
     * @param Update $update Telegram Update.
     *
     * @return $this
     */
    public function setUpdate(Update $update): self
    {
        $this->update = $update;

        return $this;
    }

    /**
     * Get Telegram Update
     *
     * @return Update
     */
    public function getUpdate(): Update
    {
        return $this->update;
    }

    /**
     * Determine Telegram Update is set.
     *
     * @return bool
     */
    public function hasUpdate(): bool
    {
        return $this->update !== null;
    }
}
