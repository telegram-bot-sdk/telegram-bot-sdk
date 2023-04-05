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
     *
     */
    public static function hasFileId(string $inputFileField, array $params): bool
    {
        return isset($params[$inputFileField]) && static::isFileId($params[$inputFileField]);
    }

    /**
     * Determine if given object is an instance of InputFile.
     *
     *
     */
    public static function isInputFile(mixed $object): bool
    {
        return $object instanceof InputFile;
    }

    /**
     * Determine the given string is a file id.
     *
     * @param string $value
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
     */
    public static function isUrl(string $value): bool
    {
        return (bool)filter_var($value, FILTER_VALIDATE_URL);
    }

    /**
     * Determine given string is a json object.
     *
     * @param string $string A json string
     */
    public static function isJson(string $string): bool
    {
        json_decode($string);

        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Determine if given object is Jsonable.
     *
     *
     */
    public static function isJsonable(mixed $object): bool
    {
        return $object instanceof Jsonable;
    }

    /**
     * Determine if given object is Multipartable.
     *
     *
     */
    public static function isMultipartable(mixed $object): bool
    {
        return $object instanceof Multipartable;
    }

    /**
     * Determine given update object has command entity.
     *
     *
     */
    public static function hasCommand(Update $update): bool
    {
        return (bool)$update->getMessage()
            ->collect()
            ->filter(fn ($val, $field): bool => Str::endsWith($field, 'entities'))
            ->flatten()
            ->contains('type', 'bot_command');
    }
}
