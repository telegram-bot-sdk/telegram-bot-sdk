<?php

namespace Telegram\Bot\Testing\Responses;

use Faker\Provider\Base;

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
        $command = $command ?? $this->generator->word();

        return '/'.$command;
    }
}
