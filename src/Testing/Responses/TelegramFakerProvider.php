<?php

namespace Telegram\Bot\Testing\Responses;

use Exception;
use Faker\Provider\Base;
use Illuminate\Support\Collection;

class TelegramFakerProvider extends Base
{
    public function id(int $digits = 9)
    {
        return $this->generator->randomNumber($digits);
    }

    public function botName()
    {
        return $this->generator->firstName().' Bot';
    }

    public function botUserName()
    {
        return $this->generator->firstName().'Bot';
    }

    public function from()
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

    public function chat()
    {
        return [
            'id' => $this->generator->randomNumber(9),
            'first_name' => $this->generator->firstName(),
            'last_name' => $this->generator->lastName(),
            'username' => $this->generator->userName(),
            'type' => 'private',
        ];
    }

    public function botFrom()
    {
        return [
            'id' => $this->generator->randomNumber(9),
            'is_bot' => true,
            'first_name' => $this->botName(),
            'username' => $this->botUserName(),
        ];
    }

    public function command(string|null $command = null)
    {
        if(str_contains($command, '?') || str_contains($command, '#')) {
            return '/'.$this->generator->bothify($command);
        }

        $command = $command ?? $this->generator->word();

        return '/'.$command;
    }

    public function commandWithArgs(string|null $command = null, string ...$args)
    {
        $arguments = (new Collection($args))->map(function ($arg) {
            if (str_starts_with($arg, 'faker-')) {
                return $this->fakerArg(str_replace('faker-', '', $arg));
            }

            return $arg;
        })->implode(' ');

        return trim($this->command($command) . ' ' . $arguments);
    }

    private function fakerArg(string $name)
    {
        try {
            if (str_contains($name, '-') === false) {
                return $this->generator->$name();
            }

            [$method, $arg] = explode('-', $name, 2);

            return $this->generator->$method($arg);
        } catch (Exception $e) {
            return $name;
        }
    }
}
