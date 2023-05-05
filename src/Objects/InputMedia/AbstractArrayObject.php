<?php

namespace Telegram\Bot\Objects\InputMedia;

use Telegram\Bot\Contracts\Multipartable;
use Telegram\Bot\Helpers\Validator;
use Telegram\Bot\Objects\AbstractCreateObject;

abstract class AbstractArrayObject extends AbstractCreateObject implements Multipartable
{
    /**
     * @return $this
     */
    public function add($object): static
    {
        $this->fields->add($object);

        return $this;
    }

    public function __toMultipart(): array
    {
        return $this->fields
            ->filter(fn ($field): bool => Validator::isMultipartable($field))
            ->flatMap(fn ($field) => $field->__toMultipart())
            ->all();
    }
}
