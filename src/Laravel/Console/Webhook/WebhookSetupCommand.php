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

        // Bot webhook config.
        $config = $bot->config('webhook', []);

        // Global webhook config merged with bot config with the latter taking precedence.
        $params = collect($bot->config('global.webhook'))->except(['domain', 'path', 'controller', 'url'])
            ->merge($config)
            ->put('url', $this->webhookUrl($bot))
            ->all();

        if ($bot->setWebhook($params)) {
            $this->info('Success: Your webhook has been set!');

            return;
        }

        $this->error('Your webhook could not be set!');
    }

    protected function webhookUrl(Bot $bot): string
    {
        if (filled($bot->config('webhook.url'))) {
            return $bot->config('webhook.url');
        }

        return Str::replaceFirst('http:', 'https:', route('telegram.bot.webhook', [
            'token' => $bot->config('token'),
            'bot'   => $bot->config('bot'),
        ]));
    }
}
