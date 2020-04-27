<?php

namespace Telegram\Bot\Laravel\Artisan;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\TableCell;
use Telegram\Bot\Bot;
use Telegram\Bot\BotsManager;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\WebhookInfo;

class WebhookCommand extends Command
{
    /** @var string The name and signature of the console command. */
    protected $signature = 'telegram:webhook {bot? : The bot name defined in the config file}
                {--all : To perform actions on all your bots.}
                {--setup : To declare your webhook on Telegram servers. So they can call you.}
                {--remove : To remove your already declared webhook on Telegram servers.}
                {--info : To get the information about your current webhook on Telegram servers.}';

    /** @var string The console command description. */
    protected $description = 'Ease the Process of setting up and removing webhooks for Telegram Bots.';

    protected Bot $bot;
    protected BotsManager $botsManager;

    /**
     * Execute the console command.
     *
     * @param BotsManager $botsManager
     *
     * @throws TelegramSDKException
     */
    public function handle(BotsManager $botsManager)
    {
        $this->botsManager = $botsManager;

        $bot = $this->argument('bot');
        $this->bot = $this->botsManager->bot($bot);

        if ($this->option('setup')) {
            $this->setupWebhook();
        }

        if ($this->option('remove')) {
            $this->removeWebhook();
        }

        if ($this->option('info')) {
            $this->getInfo();
        }
    }

    /**
     * Setup Webhook.
     *
     * @throws TelegramSDKException
     */
    protected function setupWebhook(): void
    {
        $params = [
            'url' => $this->bot->config('webhook_url'),
        ];

        if ($this->bot->hasConfig('certificate_path')) {
            $params['certificate'] = $this->bot->config('certificate_path');
        }

        if ($this->bot->setWebhook($params)) {
            $this->info('Success: Your webhook has been set!');

            return;
        }

        $this->error('Your webhook could not be set!');
    }

    /**
     * Remove Webhook.
     *
     * @throws TelegramSDKException
     */
    protected function removeWebhook(): void
    {
        if ($this->confirm("Are you sure you want to remove the webhook for {$this->bot->config('bot')}?")) {
            $this->info('Removing webhook...');

            if ($this->bot->removeWebhook()) {
                $this->info('Webhook removed successfully!');

                return;
            }

            $this->error('Webhook removal failed');
        }
    }

    /**
     * Get Webhook Info.
     */
    protected function getInfo(): void
    {
        $this->alert('Webhook Info');

        if ($this->hasArgument('bot') && !$this->option('all')) {
            $response = $this->bot->getWebhookInfo();
            $this->makeWebhookInfoResponse($response, $this->bot->config('username'));

            return;
        }

        if ($this->option('all')) {
            $bots = $this->botsManager->config('bots');
            collect($bots)->each(function ($bot, $key) {
                $response = $this->botsManager->bot($key)->getWebhookInfo();
                $this->makeWebhookInfoResponse($response, $bot['username']);
            });
        }
    }

    /**
     * Make WebhookInfo Response for console.
     *
     * @param WebhookInfo $info
     * @param string      $bot
     */
    protected function makeWebhookInfoResponse(WebhookInfo $info, string $bot): void
    {
        $rows = collect($info)->map(function ($value, $key) {
            $key = Str::title(str_replace('_', ' ', $key));
            $value = is_bool($value) ? $this->mapBool($value) : $value;

            return compact('key', 'value');
        })->toArray();

        $this->table(
            [
                [new TableCell('Bot: ' . $bot, ['colspan' => 2])],
                ['Key', 'Info'],
            ],
            $rows
        );
    }

    /**
     * Map Boolean Value to Yes/No.
     *
     * @param $value
     *
     * @return string
     */
    protected function mapBool($value): string
    {
        return $value ? 'Yes' : 'No';
    }
}
