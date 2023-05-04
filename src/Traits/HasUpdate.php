<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\ResponseObject;

/**
 * HasUpdate.
 */
trait HasUpdate
{
    protected ?ResponseObject $update = null;

    public function hasUpdate(): bool
    {
        return $this->update !== null;
    }

    /**
     * Get the Telegram Update.
     *
     * @throws TelegramSDKException
     */
    public function getUpdate(): ResponseObject
    {
        if (! $this->hasUpdate()) {
            throw TelegramSDKException::updateObjectNotFound();
        }

        return $this->update;
    }

    public function setUpdate(ResponseObject $update): self
    {
        $this->update = $update;

        return $this;
    }
}
