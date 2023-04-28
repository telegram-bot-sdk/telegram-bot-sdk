<?php

namespace Telegram\Bot\Methods;

use stdClass;
use Telegram\Bot\Traits\Http;

/**
 * Class Commands.
 *
 * @mixin Http
 */
trait Commands
{
    /**
     * Change the list of the bots commands.
     *
     * @param array{
     * 	commands: array,
     * 	scope: BotCommandScope,
     * 	language_code: String,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#setmycommands
     */
    public function setMyCommands(array $params): bool
    {
        return $this->post('setMyCommands', $params)->getResult();
    }

    /**
     * Delete the list of the bot's commands for the given scope and user language
     *
     * @param array{
     * 	scope: BotCommandScope,
     * 	language_code: String,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#deletemycommands
     */
    public function deleteMyCommands(array $params = []): bool
    {
        return $this->post('deleteMyCommands', $params)->getResult();
    }

    /**
     * Get the current list of the bot's commands.
     *
     * @param array{
     * 	scope: BotCommandScope,
     * 	language_code: String,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#getmycommands
     *
     * @return stdClass[]
     */
    public function getMyCommands(array $params = []): array
    {
        return $this->get('getMyCommands', $params)->getResult();
    }
}
