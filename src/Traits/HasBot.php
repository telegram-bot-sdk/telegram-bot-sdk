<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\Bot;

/**
 * Class HasBot.
 */
trait HasBot
{
    /** @var Bot|null Telegram Bot. */
    protected ?Bot $bot = null;

    /**
     * Determine if Telegram Bot is set.
     */
    public function hasBot(): bool
    {
        return $this->bot !== null;
    }

    /**
     * Get the Telegram Bot.
     */
    public function getBot(): ?Bot
    {
        return $this->bot;
    }

    /**
     * Set the Telegram Bot.
     *
     *
     * @return $this
     */
    public function setBot(Bot $bot): self
    {
        $this->bot = $bot;

        return $this;
    }
}
