<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\File;
use Telegram\Bot\Objects\StickerSet;
use Telegram\Bot\Objects\Updates\Message as MessageObject;
use Telegram\Bot\Traits\Http;

/**
 * Class Message.
 *
 * @mixin Http
 */
trait Stickers
{
    /**
     * Use this method to send static .WEBP or animated .TGS stickers.
     *
     * @param array{
     * 	chat_id: int|string,
     * 	sticker: InputFile|string,
     * 	disable_notification: bool,
     * 	protect_content: bool,
     * 	reply_to_message_id: int,
     * 	reply_markup: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#sendsticker
     *
     * @throws TelegramSDKException
     */
    public function sendSticker(array $params): MessageObject
    {
        $response = $this->uploadFile('sendSticker', $params);

        return new MessageObject($response->getDecodedBody());
    }

    /**
     * Get a sticker set. On success, a StickerSet object is returned.
     *
     * @param array{
     * 	name: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#getstickerset
     *
     * @throws TelegramSDKException
     */
    public function getStickerSet(array $params): StickerSet
    {
        $response = $this->post('getStickerSet', $params);

        return new StickerSet($response->getDecodedBody());
    }

    /**
     * Upload a .png file with a sticker for later use in createNewStickerSet and addStickerToSet
     * methods (can be used multiple times).
     *
     * @param array{
     * 	user_id: int,
     * 	png_sticker: InputFile,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#uploadstickerfile
     *
     * @throws TelegramSDKException
     */
    public function uploadStickerFile(array $params): File
    {
        $response = $this->uploadFile('uploadStickerFile', $params);

        return new File($response->getDecodedBody());
    }

    /**
     * Create new sticker set owned by a user.
     *
     * @param array{
     * 	user_id: int,
     * 	name: string,
     * 	title: string,
     * 	png_sticker: InputFile|string,
     * 	tgs_sticker: InputFile,
     * 	emojis: string,
     * 	contains_masks: bool,
     * 	mask_position: MaskPosition,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#createnewstickerset
     *
     * @throws TelegramSDKException
     */
    public function createNewStickerSet(array $params): bool
    {
        return $this->uploadFile('createNewStickerSet', $params)->getResult();
    }

    /**
     * Add a new sticker to a set created by the bot.
     *
     * @param array{
     * 	user_id: int,
     * 	name: string,
     * 	png_sticker: InputFile|string,
     * 	tgs_sticker: InputFile,
     * 	emojis: string,
     * 	mask_position: MaskPosition,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#addstickertoset
     *
     * @throws TelegramSDKException
     */
    public function addStickerToSet(array $params): bool
    {
        return $this->uploadFile('addStickerToSet', $params)->getResult();
    }

    /**
     * Move a sticker in a set created by the bot to a specific position.
     *
     * @param array{
     * 	sticker: string,
     * 	position: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#setstickerpositioninset
     *
     * @throws TelegramSDKException
     */
    public function setStickerPositionInSet(array $params): bool
    {
        return $this->post('setStickerPositionInSet', $params)->getResult();
    }

    /**
     * Delete a sticker from a set created by the bot.
     *
     * @param array{
     * 	sticker: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#deletestickerfromset
     *
     * @throws TelegramSDKException
     */
    public function deleteStickerFromSet(array $params): bool
    {
        return $this->post('deleteStickerFromSet', $params)->getResult();
    }

    /**
     * Set the thumbnail of a sticker set
     *
     * @param array{
     * 	name: string,
     * 	user_id: int,
     * 	thumb: InputFile|string,
     * } $params
     *
     * @throws TelegramSDKException
     */
    public function setStickerSetThumb(array $params): bool
    {
        return $this->uploadFile('setStickerSetThumb', $params)->getResult();
    }
}
