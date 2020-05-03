<?php

namespace Telegram\Bot\Laravel\Http\Controllers;

use Illuminate\Routing\Controller;
use Telegram\Bot\BotManager;
use Telegram\Bot\Exceptions\TelegramSDKException;

class WebhookController extends Controller
{
    /**
     * Listen to incoming update.
     *
     * @param BotManager $manager
     * @param string     $token
     * @param string     $bot
     *
     * @throws TelegramSDKException
     *
     * @return mixed
     */
    public function __invoke(BotManager $manager, string $token, string $bot)
    {
        $manager->bot($bot)->listen(true);

        return response()->noContent();
    }
}
