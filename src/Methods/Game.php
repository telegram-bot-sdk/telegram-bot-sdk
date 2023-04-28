<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\Http;

/**
 * Class Game.
 *
 * @mixin Http
 */
trait Game
{
    /**
     * Send a game.
     *
     * @param array{
     * 	chat_id: int|string,
     * 	game_short_name: string,
     * 	disable_notification: bool,
     * 	protect_content: bool,
     * 	reply_to_message_id: int,
     * 	reply_markup: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#sendgame
     */
    public function sendGame(array $params): ResponseObject
    {
        return $this->post('sendGame', $params)->getResult();
    }

    /**
     * Set the score of the specified user in a game.
     *
     * @param array{
     * 	user_id: int,
     * 	score: int,
     * 	force: bool,
     * 	disable_edit_message: bool,
     * 	chat_id: int,
     * 	message_id: int,
     * 	inline_message_id: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#setgamescore
     */
    public function setGameScore(array $params): ResponseObject
    {
        return $this->post('setGameScore', $params)->getResult();
    }

    /**
     * Set the score of the specified user in a game.
     *
     * @param array{
     * 	user_id: int,
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	inline_message_id: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#getgamehighscores
     *
     * @return ResponseObject[]
     */
    public function getGameHighScores(array $params): array
    {
        return $this->get('getGameHighScores', $params)->getResult();
    }
}
