<?php

namespace Telegram\Bot\Traits;

use BadMethodCallException;
use Error;

trait ForwardsCalls
{
    protected function forwardCallTo(mixed $object, string $method, array $parameters): mixed
    {
        try {
            return $object->{$method}(...$parameters);
        } catch (Error|BadMethodCallException $e) {
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

    protected static function throwBadMethodCallException(string $method): never
    {
        throw new BadMethodCallException(sprintf(
            'Call to undefined method %s::%s()',
            static::class,
            $method
        ));
    }
}
