<?php

namespace Telegram\Bot\Helpers;

use Closure;
use ReflectionException;
use ReflectionFunction;
use ReflectionMethod;

class Reflector
{
    public static function getParameters(array|string|callable $callback, ?string $method = null): array
    {
        return self::getCallReflector($callback, $method)->getParameters();
    }

    /**
     * @throws ReflectionException
     */
    public static function getCallReflector(array|string|callable $callback, ?string $method = null): ReflectionMethod|ReflectionFunction
    {
        if (is_string($callback)) {
            match (true) {
                str_contains($callback, '::') => $callback = explode('::', $callback),
                str_contains($callback, '@') => $callback = explode('@', $callback),
                default => $callback,
            };
        }

        if (is_object($callback) && ! $callback instanceof Closure) {
            $callback = [$callback, $method ?? '__invoke'];
        }

        return is_array($callback)
            ? new ReflectionMethod(...$callback)
            : new ReflectionFunction($callback);
    }
}
