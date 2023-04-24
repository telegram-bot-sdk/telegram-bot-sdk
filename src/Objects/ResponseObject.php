<?php

namespace Telegram\Bot\Objects;

use stdClass;

class ResponseObject extends stdClass
{
    private stdClass $stdObject;

    public function __construct($stdObject = new stdClass()) {
        $this->stdObject = $stdObject;
    }

    public function __get($name) {
        return $this->getPropertyValue($name);
    }

    protected function getPropertyValue($name) {
        if (property_exists($this->stdObject, $name)) {
            $value = $this->stdObject->{$name};

            return $value instanceof stdClass ? new self($value) : $value;
        }

        return null;
    }
}