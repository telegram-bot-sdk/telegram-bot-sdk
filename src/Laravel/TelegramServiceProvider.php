<?php

namespace Telegram\Bot\Laravel;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use Telegram\Bot\Api;
use Telegram\Bot\BotsManager;
use Telegram\Bot\Laravel\Artisan\WebhookCommand;

/**
 * Class TelegramServiceProvider.
 */
class TelegramServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        $source = __DIR__ . '/config/telegram.php';

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('telegram.php')], 'config');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('telegram');
        }

        $this->mergeConfigFrom($source, 'telegram');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            BotsManager::class,
            fn ($app) => (new BotsManager($app['config']['telegram']))->setContainer($app)
        );
        $this->app->alias(BotsManager::class, 'telegram');

        $this->app->bind(Api::class, fn ($app) => $app[BotsManager::class]->bot());
        $this->app->alias(Api::class, 'telegram.api');

        $this->app->bind('command.telegram:webhook', WebhookCommand::class);
        $this->commands('command.telegram:webhook');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [BotsManager::class, Api::class, 'telegram', 'telegram.api'];
    }
}
