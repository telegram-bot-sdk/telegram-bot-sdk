<?php

namespace Telegram\Bot\Objects\InputMedia;

use Telegram\Bot\Contracts\Multipartable;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Helpers\Validator;
use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * Class InputMedia.
 *
 * This object represents the content of a media message to be sent.
 */
abstract class InputMedia extends AbstractCreateObject implements Multipartable
{
    protected string $type;

    /**
     * Create a new object.
     *
     * @param array $fields
     */
    public function __construct(array $fields = [])
    {
        $fields['type'] = $this->type;

        parent::__construct($fields);
    }

    public function toMultipart(): array
    {
        return collect($this->fields)
            ->filter(fn ($field) => Validator::isMultipartable($field))
            ->map(fn (InputFile $field) => $field->toMultipart())
            ->values()
            ->all();
    }
}
