<?php

namespace Telegram\Bot\Laravel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;

class ValidateWebhook
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @throws TelegramSDKException
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        abort_unless($this->isTokenValid($request), 401);

        return $next($request);
    }

    /**
     * Determine if given request has a valid bot name and token that matches.
     *
     * @param Request $request
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function isTokenValid($request): bool
    {
        return Telegram::bot($request->route('bot'))->config('token') === $request->route('token');
    }
}
