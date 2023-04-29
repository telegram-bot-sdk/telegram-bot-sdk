<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\Http;

/**
 * Class Get.
 *
 * @mixin Http
 */
trait Get
{
    /**
     * A simple method for testing your bot's auth token.
     *
     * Returns basic information about the bot.
     *
     * @link https://core.telegram.org/bots/api#getme
     */
    public function getMe(): ResponseObject
    {
        return $this->get('getMe')->getResult();
    }

    /**
     * Returns a list of profile pictures for a user.
     *
     * @link https://core.telegram.org/bots/api#getuserprofilephotos
     *
     * @param array{
     * 	user_id: int,
     * 	offset: int,
     * 	limit: int,
     * } $params
     */
    public function getUserProfilePhotos(array $params): ResponseObject
    {
        return $this->get('getUserProfilePhotos', $params)->getResult();
    }

    /**
     * Returns basic info about a file and prepare it for downloading.
     *
     * Bots can download files of up to 20MB in size. On success, a File object
     * is returned. The file can then be downloaded via the link
     * https://api.telegram.org/file/bot< token >/< file_path >,
     * where < file_path > is taken from the response.
     *
     * It is guaranteed that the link will be valid for at least 1 hour.
     * When the link expires, a new one can be requested by calling getFile again
     *
     * @link https://core.telegram.org/bots/api#getfile
     *
     * @param array{
     * 	file_id: string,
     * } $params
     */
    public function getFile(array $params): ResponseObject
    {
        return $this->get('getFile', $params)->getResult();
    }

    /**
     * Change the bot's name
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setmyname
     *
     * @param array{
     * 	name: string,
     * 	language_code: string,
     * } $params
     */
    public function setMyName(array $params): ResponseObject
    {
        return $this->post('setMyName', $params)->getResult();
    }

    /**
     * Get the current bot name for the given user language.
     *
     * Returns BotName on success
     *
     * @link https://core.telegram.org/bots/api#getmyname
     *
     * @param array{
     * 	language_code: string,
     * } $params
     */
    public function getMyName(array $params): ResponseObject
    {
        return $this->get('getMyName', $params)->getResult();
    }

    /**
     * Change the bot's description
     *
     * Shown in the chat with the bot if the chat is empty. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setmydescription
     *
     * @param array{
     * 	description: string,
     * 	language_code: string,
     * } $params
     */
    public function setMyDescription(array $params): bool
    {
        return $this->post('setMyDescription', $params)->getResult();
    }

    /**
     * Get the current bot description for the given user language
     *
     * Returns BotDescription on success.
     *
     * @link https://core.telegram.org/bots/api#getmydescription
     *
     * @param array{
     * 	language_code: string,
     * } $params
     * @return ResponseObject{
     *  description: string
     * }
     */
    public function getMyDescription(array $params): ResponseObject
    {
        return $this->get('getMyDescription', $params)->getResult();
    }

    /**
     * Change the bot's short description
     *
     * Shown on the bot's profile page and is sent together with the link when users share the bot. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setmyshortdescription
     *
     * @param array{
     * 	short_description: string,
     * 	language_code: string,
     * } $params
     */
    public function setMyShortDescription(array $params): bool
    {
        return $this->post('setMyShortDescription', $params)->getResult();
    }

    /**
     * Get the current bot short description for the given user language
     *
     * Returns BotShortDescription on success.
     *
     * @link https://core.telegram.org/bots/api#getmydescription
     *
     * @param array{
     * 	language_code: string,
     * } $params
     * @return ResponseObject{
     *  short_description: string
     * }
     */
    public function getMyShortDescription(array $params): ResponseObject
    {
        return $this->get('getMyShortDescription', $params)->getResult();
    }

    /**
     * Change the default administrator rights requested by the bot when it's added as an administrator to groups or channels
     *
     * These rights will be suggested to users, but they are free to modify the list before adding the bot. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setmydefaultadministratorrights
     *
     * @param array{
     *  rights: array,
     * 	for_channels: bool,
     * } $params
     */
    public function setMyDefaultAdministratorRights(array $params): ResponseObject
    {
        return $this->post('setMyDefaultAdministratorRights', $params)->getResult();
    }

    /**
     * get the current default administrator rights of the bot
     *
     * Returns ChatAdministratorRights on success.
     *
     * @link https://core.telegram.org/bots/api#getmydefaultadministratorrights
     *
     * @param array{
     * 	for_channels: bool,
     * } $params
     */
    public function getMyDefaultAdministratorRights(array $params): ResponseObject
    {
        return $this->post('getMyDefaultAdministratorRights', $params)->getResult();
    }
}
