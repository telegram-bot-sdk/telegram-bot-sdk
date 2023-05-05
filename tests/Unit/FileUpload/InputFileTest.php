<?php

use Psr\Http\Message\StreamInterface;
use Telegram\Bot\FileUpload\InputFile;
use GuzzleHttp\Psr7\LazyOpenStream;

it('can create an InputFile from a file', function () {
    $file = InputFile::file(__DIR__.'/test.txt', 'test.txt');
    expect($file->getFilename())->toBe('test.txt')
        ->and($file->getContents())->toBeInstanceOf(LazyOpenStream::class);
});

it('can create an InputFile from contents', function () {
    $contents = 'test';
    $file = InputFile::contents($contents, 'test.txt');
    expect($file->getFilename())->toBe('test.txt')
        ->and($file->getContents())->toBeInstanceOf(StreamInterface::class);
});

it('can get and set the multipart name', function () {
    $file = InputFile::file(__DIR__.'/test.txt', 'test.txt');
    $file->setMultipartName('test');
    expect($file->getMultipartName())->toBe('test');
});

it('can get the attach string', function () {
    $file = InputFile::file(__DIR__.'/test.txt', 'test.txt');
    expect($file->getAttachString())->toBe('attach://'.$file->getMultipartName());
});

it('can be converted to multipart', function () {
    $file = InputFile::file(__DIR__.'/test.txt', 'test.txt');
    $multipart = $file->__toMultipart();
    expect($multipart)->toBeArray()
        ->and($multipart)->toHaveKeys(['name', 'contents', 'filename']);
});

it('can be json serialized', function () {
    $file = InputFile::file(__DIR__.'/test.txt', 'test.txt');
    $json = json_encode($file);
    expect($json)->toBe('"attach:\/\/'.$file->getMultipartName().'"');
});
