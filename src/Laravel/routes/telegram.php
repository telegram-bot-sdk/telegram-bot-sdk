<?php

use Illuminate\Support\Facades\Route;

Route::post('/{token}/{bot}', config('telegram.webhook.controller'))->name('telegram.bot.webhook');
