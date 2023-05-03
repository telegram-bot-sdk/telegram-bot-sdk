<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\Keyboard\ForceReply;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\Keyboard\ReplyKeyboardMarkup;
use Telegram\Bot\Objects\Keyboard\ReplyKeyboardRemove;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Objects\Stickers\InputSticker;
use Telegram\Bot\Objects\Stickers\MaskPosition;
use Telegram\Bot\Traits\Http;

/**
 * @mixin Http
 */
trait Stickers
{
    /**
     * Use this method to send static .WEBP or animated .TGS stickers.
     *
     * On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#sendsticker
     *
     * @param array{
     * 	chat_id: int|string,
     *  message_thread_id: int,
     * 	sticker: InputFile|string,
     *  emoji: string,
     * 	disable_notification: bool,
     * 	protect_content: bool,
     * 	reply_to_message_id: int,
     *  allow_sending_without_reply: bool,
     *  reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     */
    public function sendSticker(array $params): ResponseObject
    {
        return $this->uploadFile('sendSticker', $params)->getResult();
    }

    /**
     * Get a sticker set. On success, a StickerSet object is returned.
     *
     * @link https://core.telegram.org/bots/api#getstickerset
     *
     * @param array{
     * 	name: string,
     * } $params
     */
    public function getStickerSet(array $params): ResponseObject
    {
        return $this->post('getStickerSet', $params)->getResult();
    }

    /**
     * Get information about custom emoji stickers by their identifiers
     *
     * Returns an Array of Sticker objects.
     *
     * @link https://core.telegram.org/bots/api#getcustomemojistickers
     *
     * @param array{
     * 	custom_emoji_ids: string[],
     * } $params
     * @return ResponseObject<array>
     */
    public function getCustomEmojiStickers(array $params): ResponseObject
    {
        return $this->post('getCustomEmojiStickers', $params)->getResult();
    }

    /**
     * Upload a file with a sticker for later use in the createNewStickerSet and
     * addStickerToSet methods (the file can be used multiple times).
     * Returns the uploaded File on success.
     *
     * @link https://core.telegram.org/bots/api#uploadstickerfile
     *
     * @param array{
     * 	user_id: int,
     * 	sticker: InputFile,
     *  sticker_format: string
     * } $params
     * @return ResponseObject{
     *     file_id: string,
     *     file_unique_id: string,
     *     file_size: int,
     *     file_path: string,
     * }
     */
    public function uploadStickerFile(array $params): ResponseObject
    {
        return $this->uploadFile('uploadStickerFile', $params)->getResult();
    }

    /**
     * Create new sticker set owned by a user.
     *
     * The bot will be able to edit the sticker set thus created. Returns True on success
     *
     * @link https://core.telegram.org/bots/api#createnewstickerset
     *
     * @param array{
     * 	user_id: int,
     * 	name: string,
     * 	title: string,
     * 	stickers: InputSticker[],
     * 	sticker_format: string,
     * 	sticker_type: string,
     * 	needs_repainting: bool,
     * } $params
     */
    public function createNewStickerSet(array $params): bool
    {
        return $this->uploadFile('createNewStickerSet', $params)->getResult();
    }

    /**
     * Add a new sticker to a set created by the bot.
     *
     * The format of the added sticker must match the format of the other stickers in the set. Emoji sticker sets can have up to 200 stickers. Animated and video sticker sets can have up to 50 stickers. Static sticker sets can have up to 120 stickers. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#addstickertoset
     *
     * @param array{
     * 	user_id: int,
     * 	name: string,
     * 	sticker: InputSticker,
     * } $params
     */
    public function addStickerToSet(array $params): bool
    {
        return $this->uploadFile('addStickerToSet', $params)->getResult();
    }

    /**
     * Move a sticker in a set created by the bot to a specific position.
     *
     * @link https://core.telegram.org/bots/api#setstickerpositioninset
     *
     * @param array{
     * 	sticker: string,
     * 	position: string,
     * } $params
     */
    public function setStickerPositionInSet(array $params): bool
    {
        return $this->post('setStickerPositionInSet', $params)->getResult();
    }

    /**
     * Delete a sticker from a set created by the bot.
     *
     * @link https://core.telegram.org/bots/api#deletestickerfromset
     *
     * @param array{
     * 	sticker: string,
     * } $params
     */
    public function deleteStickerFromSet(array $params): bool
    {
        return $this->post('deleteStickerFromSet', $params)->getResult();
    }

    /**
     * Change the list of emoji assigned to a regular or custom emoji sticker
     *
     * The sticker must belong to a sticker set created by the bot. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setstickeremojilist
     *
     * @param array{
     * 	sticker: string,
     * 	emoji_list: string[],
     * } $params
     */
    public function setStickerEmojiList(array $params): bool
    {
        return $this->post('setStickerEmojiList', $params)->getResult();
    }

    /**
     * Change search keywords assigned to a regular or custom emoji sticker
     *
     * The sticker must belong to a sticker set created by the bot. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setstickerkeywords
     *
     * @param array{
     * 	sticker: string,
     * 	keywords: string[],
     * } $params
     */
    public function setStickerKeywords(array $params): bool
    {
        return $this->post('setStickerKeywords', $params)->getResult();
    }

    /**
     * Change the mask position of a mask sticker
     *
     * The sticker must belong to a sticker set that was created by the bot. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setstickermaskposition
     *
     * @param array{
     * 	sticker: string,
     * 	mask_position: MaskPosition
     * } $params
     */
    public function setStickerMaskPosition(array $params): bool
    {
        return $this->post('setStickerMaskPosition', $params)->getResult();
    }

    /**
     * Set the title of a created sticker set
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setstickersettitle
     *
     * @param array{
     * 	name: string,
     * 	title: string,
     * } $params
     */
    public function setStickerSetTitle(array $params): bool
    {
        return $this->post('setStickerSetTitle', $params)->getResult();
    }

    /**
     * Set the thumbnail of a regular or mask sticker set
     *
     * The format of the thumbnail file must match the format of the stickers in the set. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setstickersetthumbnail
     *
     * @param array{
     * 	name: string,
     * 	user_id: int,
     * 	thumbnail: InputFile|string,
     * } $params
     */
    public function setStickerSetThumbnail(array $params): bool
    {
        return $this->uploadFile('setStickerSetThumb', $params)->getResult();
    }

    /**
     * set the thumbnail of a custom emoji sticker set
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setcustomemojistickersetthumbnail
     *
     * @param array{
     * 	name: string,
     * 	custom_emoji_id: string,
     * } $params
     */
    public function setCustomEmojiStickerSetThumbnail(array $params): bool
    {
        return $this->post('setCustomEmojiStickerSetThumbnail', $params)->getResult();
    }

    /**
     * Delete a sticker set that was created by the bot
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#deletestickerset
     *
     * @param array{
     * 	name: string,
     * } $params
     */
    public function deleteStickerSet(array $params): bool
    {
        return $this->post('deleteStickerSet', $params)->getResult();
    }
}
