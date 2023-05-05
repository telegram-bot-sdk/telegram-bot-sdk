<?php

use Telegram\Bot\Helpers\Entities;

it('can format text with bold entities', function () {
    $text = 'Hello, world!';
    $entities = [
        [
            'type' => 'bold',
            'offset' => 7,
            'length' => 5,
        ],
    ];
    $formatted = Entities::format($text)->withEntities($entities)->toMarkdown();
    expect($formatted)->toBe('Hello, *world*!');
});

it('can format text with italic entities', function () {
    $text = 'Hello, world!';
    $entities = [
        [
            'type' => 'italic',
            'offset' => 7,
            'length' => 5,
        ],
    ];
    $formatted = Entities::format($text)->withEntities($entities)->toMarkdown();
    expect($formatted)->toBe('Hello, _world_!');
});

it('can format text with code entities', function () {
    $text = 'Hello, world!';
    $entities = [
        [
            'type' => 'code',
            'offset' => 7,
            'length' => 5,
        ],
    ];
    $formatted = Entities::format($text)->withEntities($entities)->toMarkdown();
    expect($formatted)->toBe('Hello, `world`!');
});

it('can format text with pre entities with tabs and spaces', function () {
    $text = "Hello, \n\tworld\n  \n\t\n!";
    $entities = [
        [
            'type' => 'pre',
            'offset' => 8,
            'length' => 11,
        ],
    ];
    $formatted = Entities::format($text)->withEntities($entities)->toHTML();
    expect($formatted)->toBe("Hello, \n<pre>\tworld\n  \n\t</pre>\n!");
});



it('can format text with text_mention entities', function () {
    $text = 'Hello, @username!';
    $entities = [
        [
            'type' => 'text_mention',
            'offset' => 7,
            'length' => 9,
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'username' => 'username',
                'language_code' => 'en',
            ],
        ],
    ];
    $formatted = Entities::format($text)->withEntities($entities)->toHTML();
    expect($formatted)->toBe('Hello, <a href="tg://user?id=username">username</a>!');
});

it('can format text with text_link entities', function () {
    $text = 'Hello, world!';
    $entities = [
        [
            'type' => 'text_link',
            'offset' => 7,
            'length' => 5,
            'url' => 'https://example.com',
        ],
    ];
    $formatted = Entities::format($text)->withEntities($entities)->toHTML();
    expect($formatted)->toBe('Hello, <a href="https://example.com">world</a>!');
});
