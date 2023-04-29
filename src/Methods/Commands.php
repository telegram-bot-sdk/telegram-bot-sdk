<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\BotCommandScope\BotCommandScope;
use Telegram\Bot\Objects\ResponseObject;
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
     * Returns True on success
     *
     * @link https://core.telegram.org/bots/api#setmycommands
     *
     * @param array{
     * 	commands: array<int, array{command: string, description: string}>,
     * 	scope: BotCommandScope[],
     * 	language_code: String,
     * } $params
     */
    public function setMyCommands(array $params): bool
    {
        return $this->post('setMyCommands', $params)->getResult();
    }

    /**
     * Delete the list of the bot's commands for the given scope and user language
     *
     * After deletion, higher level commands will be shown to affected users. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#deletemycommands
     *
     * @param array{
     * 	scope: BotCommandScope,
     * 	language_code: String,
     * } $params
     */
    public function deleteMyCommands(array $params): bool
    {
        return $this->post('deleteMyCommands', $params)->getResult();
    }

    /**
     * Get the current list of the bot's commands for the given scope and user language
     *
     * Returns an Array of BotCommand objects. If commands aren't set, an empty list is returned
     *
     * @link https://core.telegram.org/bots/api#getmycommands
     *
     * @param array{
     * 	scope: BotCommandScope,
     * 	language_code: String,
     * } $params
     * @return ResponseObject[]
     */
    public function getMyCommands(array $params = []): array
    {
        return $this->get('getMyCommands', $params)->getResult();
    }
}
