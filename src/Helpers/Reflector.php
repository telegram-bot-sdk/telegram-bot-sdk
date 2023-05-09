<?php

namespace Telegram\Bot\Helpers;

use Closure;
use ReflectionException;
use ReflectionFunction;
use ReflectionMethod;

class Reflector
{
    public static function getParameters(array|string|callable $callback): array
    {
        return self::getCallReflector($callback)->getParameters();
    }

    /**
     * @throws ReflectionException
     */
    public static function getCallReflector(array|string|callable $callback): ReflectionMethod|ReflectionFunction
    {
        if (is_string($callback)) {
            match (true) {
                str_contains($callback, '::') => $callback = explode('::', $callback),
                str_contains($callback, '@') => $callback = explode('@', $callback),
                default => $callback,
            };
        }

        if (is_object($callback) && ! $callback instanceof Closure) {
            $callback = [$callback, '__invoke'];
        }

        return is_array($callback)
            ? new ReflectionMethod(...$callback)
            : new ReflectionFunction($callback);
    }
}
