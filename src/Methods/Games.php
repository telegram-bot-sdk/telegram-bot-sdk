<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\Http;

/**
 * @mixin Http
 */
trait Games
{
    /**
     * Send a game.
     *
     * On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#sendgame
     *
     * @param array{
     *    chat_id: int|string,
     *    message_thread_id: int,
     *    game_short_name: string,
     *    disable_notification: bool,
     *    protect_content: bool,
     *    reply_to_message_id: int,
     *    allow_sending_without_reply: bool,
     *    reply_markup: InlineKeyboardMarkup,
     * } $params
     */
    public function sendGame(array $params): ResponseObject
    {
        return $this->post('sendGame', $params)->getResult();
    }

    /**
     * Set the score of the specified user in a game.
     *
     * On success, if the message is not an inline message, the Message is returned, otherwise True is returned. Returns an error, if the new score is not greater than the user's current score in the chat and force is False.
     *
     * @link https://core.telegram.org/bots/api#setgamescore
     *
     * @param array{
     *    user_id: int,
     *    score: int,
     *    force: bool,
     *    disable_edit_message: bool,
     *    chat_id: int,
     *    message_id: int,
     *    inline_message_id: string,
     * } $params
     */
    public function setGameScore(array $params): ResponseObject|bool
    {
        return $this->post('setGameScore', $params)->getResult();
    }

    /**
     * Set the score of the specified user in a game.
     *
     * Will return the score of the specified user and several of their neighbors in a game. Returns an Array of GameHighScore objects.
     *
     * @link https://core.telegram.org/bots/api#getgamehighscores
     *
     * @param array{
     *    user_id: int,
     *    chat_id: int,
     *    message_id: int,
     *    inline_message_id: string,
     * } $params
     *
     * @return ResponseObject<array{position: int, user: array, score: int}>
     */
    public function getGameHighScores(array $params): ResponseObject
    {
        return $this->get('getGameHighScores', $params)->getResult();
    }
}
