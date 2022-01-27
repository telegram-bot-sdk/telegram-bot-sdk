<?php

namespace Telegram\Bot\Objects\BotCommandScope;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * This object represents the scope to which bot commands are applied.
 */
abstract class BotCommandScope extends AbstractCreateObject
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
