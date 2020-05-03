<?php

namespace Telegram\Bot\Laravel\Http\Controllers;

use Illuminate\Routing\Controller;
use Telegram\Bot\BotsManager;
use Telegram\Bot\Exceptions\TelegramSDKException;

class WebhookController extends Controller
{
    /**
     * Listen to incoming update.
     *
     * @param BotsManager $manager
     * @param string      $token
     * @param string      $bot
     *
     * @throws TelegramSDKException
     *
     * @return mixed
     */
    public function __invoke(BotsManager $manager, string $token, string $bot)
    {
        $manager->bot($bot)->listen(true);

        return response('Accepted');
    }
}
