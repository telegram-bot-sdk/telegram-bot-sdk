<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\BotCommand;
use Telegram\Bot\Traits\Http;

/**
 * Class Commands.
 *
 * @mixin Http
 */
trait Commands
{
    /**
     * Get the current list of the bot's commands.
     *
     * @link https://core.telegram.org/bots/api#getmycommands
     *
     * @throws TelegramSDKException
     * @return BotCommand[]
     */
    public function getMyCommands(): array
    {
        return collect($this->get('getMyCommands')->getResult())
            ->mapInto(BotCommand::class)
            ->all();
    }

    /**
     * Change the list of the bot's commands.
     *
     * <code>
     * $params = [
     *      'commands'  => '',  // array - Required. A JSON-serialized list of bot commands to be set as the list of the bot's commands. At most 100 commands can be specified.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setmycommands
     *
     * @param array $params
     *
     * @throws TelegramSDKException
     * @return bool
     */
    public function setMyCommands(array $params): bool
    {
        $params['commands'] = json_encode($params['commands']);

        return $this->post('setMyCommands', $params)->getResult();
    }
}
