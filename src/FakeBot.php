<?php

namespace Telegram\Bot;

use PHPUnit\Framework\Assert as PHPUnit;

class FakeBot extends Bot
{
    public static bool $recording = false;

    public array $calledMethods = [];

    public function __call($method, $parameters)
    {
        if (self::$recording) {
            $this->calledMethods[] = [$method, $parameters[0]];
        } else {
            parent::__call($method, $parameters);
        }
    }

    public function assertApiMethodWasCalled(string $methodName, $times = 1)
    {
        $count = collect($this->calledMethods)->filter(fn ($value) => is_array($value) && in_array($methodName, $value))->count();

        PHPUnit::assertSame(
            $times,
            $count,
            "The expected method was called [{$count}] times instead of [{$times}]."
        );
    }

    public function assertApiPayloadToMatch(string $methodName, iterable $array, string $message = ''): self
    {
        foreach ($this->calledMethods as $calledMethod) {
            if (is_array($calledMethod) && $calledMethod[0] === $methodName) {
                $payload = $calledMethod[1];
                foreach ($array as $key => $value) {
                    PHPUnit::assertArrayHasKey($key, $payload, $message);

                    if ($message === '') {
                        $message = sprintf(
                            'Failed asserting that an array has a key %s with the value %s.',
                            $key,
                            $payload[$key],
                        );
                    }

                    PHPUnit::assertEquals($value, $payload[$key], $message);
                }
            }
        }

        return $this;
    }
}
