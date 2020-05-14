<?php

namespace Telegram\Bot\Objects\InputMedia;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * Class InputMedia.
 *
 * This object represents the content of a media message to be sent.
 */
abstract class InputMedia extends AbstractCreateObject
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
}
