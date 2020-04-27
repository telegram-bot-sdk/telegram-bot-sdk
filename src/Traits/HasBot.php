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
     *
     * @return bool
     */
    public function hasBot(): bool
    {
        return $this->bot !== null;
    }

    /**
     * Get the Telegram Bot.
     *
     * @return Bot
     */
    public function getBot(): Bot
    {
        return $this->bot;
    }

    /**
     * Set the Telegram Bot.
     *
     * @param Bot $bot
     *
     * @return $this
     */
    public function setBot(Bot $bot): self
    {
        $this->bot = $bot;

        return $this;
    }
}
