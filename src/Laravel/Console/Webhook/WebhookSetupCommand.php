<?php

namespace Telegram\Bot\Laravel\Console\Webhook;

use Illuminate\Support\Str;
use Telegram\Bot\Bot;
use Telegram\Bot\Exceptions\TelegramSDKException;

class WebhookSetupCommand extends ConsoleBaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'telegram:webhook:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup webhook with Telegram Bot API';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $this->setupWebhook($this->bot());
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Setup Webhook.
     *
     * @param Bot $bot
     *
     * @throws TelegramSDKException
     */
    protected function setupWebhook(Bot $bot): void
    {
        $this->comment("Setting webhook for [{$bot->config('bot')}] bot!");

        $params = $bot->config('webhook', []);

        $this->webhookUrl($bot, $params);

        if ($bot->setWebhook($params)) {
            $this->info('Success: Your webhook has been set!');

            return;
        }

        $this->error('Your webhook could not be set!');
    }

    protected function webhookUrl(Bot $bot, array &$params): void
    {
        if (!$bot->hasConfig('webhook.url') || blank($params['url'])) {
            $url = route('telegram.bot.webhook', [
                'token' => $bot->config('token'),
                'bot'   => $bot->config('bot'),
            ]);

            $params['url'] = Str::replaceFirst('http:', 'https:', $url);
        }
    }
}
