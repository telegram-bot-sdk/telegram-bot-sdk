<?php

namespace Telegram\Bot\Answers;

use BadMethodCallException;
use Telegram\Bot\Traits\HasBot;

/**
 * Class AnswerBus.
 */
abstract class AnswerBus
{
    use HasBot;

    /**
     * Handle calls to missing methods.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @throws BadMethodCallException
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this, $method)) {
            return $this->{$method}(...$parameters);
        }

        throw new BadMethodCallException("Method [$method] does not exist.");
    }
}
