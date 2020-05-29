<?php

namespace Telegram\Bot\Helpers;

use Illuminate\Support\Str;
use Telegram\Bot\Contracts\Jsonable;
use Telegram\Bot\Contracts\Multipartable;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\Update;

/**
 * Validator.
 */
class Validator
{
    /**
     * Determine given param in params array is a file id.
     *
     * @param string $inputFileField
     * @param array  $params
     *
     * @return bool
     */
    public static function hasFileId(string $inputFileField, array $params): bool
    {
        return isset($params[$inputFileField]) && static::isFileId($params[$inputFileField]);
    }

    /**
     * Determine if given object is an instance of InputFile.
     *
     * @param mixed $object
     *
     * @return bool
     */
    public static function isInputFile($object): bool
    {
        return $object instanceof InputFile;
    }

    /**
     * Determine the given string is a file id.
     *
     * @param string $value
     *
     * @return bool
     */
    public static function isFileId($value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        return preg_match('/^[\w\-]{20,}+$/u', trim($value)) > 0;
    }

    /**
     * Determine given string is a URL.
     *
     * @param string $value A filename or URL to a sticker
     *
     * @return bool
     */
    public static function isUrl(string $value): bool
    {
        return (bool)filter_var($value, FILTER_VALIDATE_URL);
    }

    /**
     * Determine given string is a json object.
     *
     * @param string $string A json string
     *
     * @return bool
     */
    public static function isJson(string $string): bool
    {
        json_decode($string);

        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Determine if given object is Jsonable.
     *
     * @param mixed $object
     *
     * @return bool
     */
    public static function isJsonable($object): bool
    {
        return $object instanceof Jsonable;
    }

    /**
     * Determine if given object is Multipartable.
     *
     * @param mixed $object
     *
     * @return bool
     */
    public static function isMultipartable($object): bool
    {
        return $object instanceof Multipartable;
    }

    /**
     * Determine given update object has command entity.
     *
     * @param Update $update
     *
     * @return bool
     */
    public static function hasCommand(Update $update): bool
    {
        return (bool)$update->getMessage()
            ->collect()
            ->filter(fn ($val, $field) => Str::endsWith($field, 'entities'))
            ->flatten()
            ->contains('type', 'bot_command');
    }
}
