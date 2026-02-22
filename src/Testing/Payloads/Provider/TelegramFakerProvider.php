<?php

namespace Telegram\Bot\Testing\Payloads\Provider;

use Exception;
use Faker\Provider\Base;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

final class TelegramFakerProvider extends Base
{
    public function id($digits = 9): int
    {
        $pat = str_repeat('#', $digits - 1);
        $res = $this->generator->numerify($pat);

        return (int) ('1'.$res);
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

    public function fileId(int $length = 36): string
    {
        return $this->generator->lexify(str_repeat('?', $length));
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

    /**
     * Generates a command entities array for a given command text.
     *
     * @param  string|null  $commandText  The full command text, e.g., "/start" or "/help arg1"
     * @return array<array{offset: int, length: int, type: string}>
     */
    public function commandEntities(?string $commandText = null): array
    {
        if ($commandText === null || ! Str::startsWith($commandText, '/')) {
            return [];
        }

        $offset = 0;
        $length = Str::length($commandText); // Default to full string if no space or @

        $firstSpace = mb_strpos($commandText, ' ');
        $atSymbolIndex = mb_strpos($commandText, '@');

        if ($atSymbolIndex !== false) {
            // Command is /command@botusername
            if ($firstSpace === false || $atSymbolIndex < $firstSpace) {
                $length = ($firstSpace === false) ? Str::length($commandText) : $firstSpace;
            }
        } elseif ($firstSpace !== false) {
            // Command is /command with args
            $length = $firstSpace;
        }
        // If no space and no @, length is just the full command string (e.g., "/start")

        return [
            [
                'offset' => $offset,
                'length' => $length,
                'type' => 'bot_command',
            ],
        ];
    }
}
