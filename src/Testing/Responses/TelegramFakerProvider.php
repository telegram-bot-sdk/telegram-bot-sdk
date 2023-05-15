<?php

namespace Telegram\Bot\Testing\Responses;

use Faker\Provider\Base;

class TelegramFakerProvider extends Base
{
    public function id()
    {
        return $this->generator->randomNumber(9);
    }

    public function botName()
    {
        return $this->generator->firstName() . ' Bot';
    }

    public function botUserName()
    {
        return $this->generator->firstName() . 'Bot';
    }
}
