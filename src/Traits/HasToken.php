<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * HasToken.
 */
trait HasToken
{
    /** @var string|null Telegram Bot Token. */
    protected ?string $token = null;

    /**
     * Determine if bot token is set.
     */
    public function hasToken(): bool
    {
        return $this->token !== null;
    }

    /**
     * Get the bot token.
     *
     * @throws TelegramSDKException
     */
    public function getToken(): string
    {
        if (! $this->hasToken()) {
            throw TelegramSDKException::tokenNotProvided();
        }

        return $this->token;
    }

    /**
     * Set the bot token.
     *
     * @param  string  $token  The bot token.
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
