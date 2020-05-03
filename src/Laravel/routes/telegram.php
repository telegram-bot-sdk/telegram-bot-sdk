<?php

use Illuminate\Support\Facades\Route;

Route::post('/{token}/{bot}', 'WebhookController')->name('telegram.bot.webhook');
