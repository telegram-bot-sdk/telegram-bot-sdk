<?php

namespace Telegram\Bot\Traits;

use BadMethodCallException;
use Error;

/**
 * ForwardsCalls.
 */
trait ForwardsCalls
{
    /**
     * Forward a method call to the given object.
     *
     *
     * @throws BadMethodCallException
     * @return mixed
     */
    protected function forwardCallTo(mixed $object, string $method, array $parameters)
    {
        try {
            return $object->{$method}(...$parameters);
        } catch (Error | BadMethodCallException $e) {
            $pattern = '~^Call to undefined method (?P<class>[^:]+)::(?P<method>[^\(]+)\(\)$~';

            if (! preg_match($pattern, $e->getMessage(), $matches)) {
                throw $e;
            }

            if ($matches['method'] !== $method || $matches['class'] !== $object::class) {
                throw $e;
            }

            static::throwBadMethodCallException($method);
        }
    }

    /**
     * Throw a bad method call exception for the given method.
     *
     *
     * @throws BadMethodCallException
     * @return void
     */
    protected static function throwBadMethodCallException(string $method): never
    {
        throw new BadMethodCallException(sprintf(
            'Call to undefined method %s::%s()',
            static::class,
            $method
        ));
    }
}
