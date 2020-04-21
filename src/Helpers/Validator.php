<?php

namespace Telegram\Bot\Helpers;

use Telegram\Bot\FileUpload\InputFile;

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
     * Determine if given contents are an instance of InputFile.
     *
     * @param $contents
     *
     * @return bool
     */
    public static function isInputFile($contents): bool
    {
        return $contents instanceof InputFile;
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
        if (!is_string($value)) {
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

        return json_last_error() == JSON_ERROR_NONE;
    }
}
