<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * HasAccessToken.
 */
trait HasAccessToken
{
    /** @var string|null Telegram Bot API Access Token. */
    protected ?string $accessToken = null;

    /**
     * Determine if bot access token is set.
     *
     * @return bool
     */
    public function hasAccessToken(): bool
    {
        return $this->accessToken !== null;
    }

    /**
     * Get the bot access token.
     *
     * @throws TelegramSDKException
     * @return string
     */
    public function getAccessToken(): string
    {
        if (!$this->hasAccessToken()) {
            throw TelegramSDKException::tokenNotProvided();
        }

        return $this->accessToken;
    }

    /**
     * Set the bot access token.
     *
     * @param string $accessToken The bot access token.
     *
     * @return $this
     */
    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }
}
