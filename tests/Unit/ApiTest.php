<?php

use Telegram\Bot\Objects\ResponseObject;

it('can call getMe', function() {
    $user = ResponseObject::factory()->asResult()->user([
        'id' => 123456789,
    ]);

    $bot = mockBotManager($user);

    $response = $bot->getMe();

    expect($response)->toBeInstanceOf(ResponseObject::class)
        ->and($response->id)->toBe(123456789);
});
