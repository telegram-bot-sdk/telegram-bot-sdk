<?php

namespace Telegram\Bot\Testing\Responses;

use Exception;
use Faker\Provider\Base;
use Illuminate\Support\Collection;

final class TelegramFakerProvider extends Base
{
    public function id(int $digits = 9): int
    {
        return $this->generator->randomNumber($digits);
    }

    public function botName(): string
    {
        return $this->generator->firstName().' Bot';
    }

    public function botUserName(): string
    {
        return $this->generator->firstName().'Bot';
    }

    /**
     * @return array{id: int, is_bot: false, first_name: string, last_name: string, username: string, language_code: string}
     */
    public function from(): array
    {
        return [
            'id' => $this->generator->randomNumber(9),
            'is_bot' => false,
            'first_name' => $this->generator->firstName(),
            'last_name' => $this->generator->lastName(),
            'username' => $this->generator->userName(),
            'language_code' => $this->generator->languageCode(),
        ];
    }

    /**
     * @return array{id: int, first_name: string, last_name: string, username: string, type: string}
     */
    public function chat(): array
    {
        return [
            'id' => $this->generator->randomNumber(9),
            'first_name' => $this->generator->firstName(),
            'last_name' => $this->generator->lastName(),
            'username' => $this->generator->userName(),
            'type' => 'private',
        ];
    }

    /**
     * @return array{id: int, is_bot: true, first_name: mixed, username: mixed}
     */
    public function botFrom(): array
    {
        return [
            'id' => $this->generator->randomNumber(9),
            'is_bot' => true,
            'first_name' => $this->botName(),
            'username' => $this->botUserName(),
        ];
    }

    public function command(?string $command = null): string
    {
        if (str_contains($command, '?')) {
            return '/'.$this->generator->bothify($command);
        }

        if (str_contains($command, '#')) {
            return '/'.$this->generator->bothify($command);
        }

        $command ??= $this->generator->word();

        return '/'.$command;
    }

    public function commandWithArgs(?string $command = null, string ...$args): string
    {
        $arguments = (new Collection($args))->map(function ($arg) {
            if (str_starts_with($arg, 'faker-')) {
                return $this->fakerArg(str_replace('faker-', '', $arg));
            }

            return $arg;
        })->implode(' ');

        return trim($this->command($command).' '.$arguments);
    }

    private function fakerArg(string $name)
    {
        try {
            if (! str_contains($name, '-')) {
                return $this->generator->$name();
            }

            [$method, $arg] = explode('-', $name, 2);

            return $this->generator->$method($arg);
        } catch (Exception) {
            return $name;
        }
    }
}
