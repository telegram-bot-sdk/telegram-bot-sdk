<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\File;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Objects\User;
use Telegram\Bot\Objects\UserProfilePhotos;
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
     * https://api.telegram.org/file/bot<token>/<file_path>,
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
}
