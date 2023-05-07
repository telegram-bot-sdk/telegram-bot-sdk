<?php

use Illuminate\Support\Collection;
use Telegram\Bot\Objects\ResponseObject;

it('can add custom data to the response object', function () {
    $response = new ResponseObject(['foo' => 'bar']);
    $response = $response->withCustomData('baz', 'qux');

    expect($response->jsonSerialize())->toBe(['foo' => 'bar', 'custom_data' => ['baz' => 'qux']]);
});

it('can add custom data without a key', function () {
    $response = new ResponseObject(['custom_data' => ['foo' => 'bar']]);
    $response = $response->withCustomData(null, 'baz');

    expect($response->getCustomData())->toBe(['foo' => 'bar', 'baz']);
});

it('can get custom data from the response object', function () {
    $response = new ResponseObject(['custom_data' => ['foo' => 'bar']]);

    expect($response->getCustomData())->toBe(['foo' => 'bar']);
});

it('throws an exception when trying to set an offset', function () {
    $response = new ResponseObject(['foo' => 'bar']);

    $response['baz'] = 'qux';
})->expectException(LogicException::class);

it('throws an exception when trying to use __set', function () {
    $response = new ResponseObject(['foo' => 'bar']);
    $response->__set('baz', 'qux');
})
    ->expectException(LogicException::class);

it('can count the number of fields in the response object', function () {
    $response = new ResponseObject(['foo' => 'bar', 'baz' => 'qux']);

    expect($response->count())->toBe(2);
});

it('can return a collection of fields in the response object', function () {
    $response = new ResponseObject(['foo' => 'bar', 'baz' => 'qux']);

    expect($response->collect())->toBeInstanceOf(Collection::class);
});

it('can find a specific type of field in the response object', function () {
    $response = new ResponseObject(['foo' => 'bar', 'baz' => 'qux']);

    expect($response->findType(['foo', 'bar']))->toBe('foo');
});

it('can get a field value using array access', function () {
    $response = new ResponseObject(['foo' => 'bar']);

    expect($response['foo'])->toBe('bar');
});

it('can get a field value in an object syntax', function () {
    $response = new ResponseObject(['foo' => 'bar']);

    expect($response->foo)->toBe('bar');
});

it('can return null when a field does not exist', function () {
    $response = new ResponseObject(['foo' => 'bar']);

    expect($response->some)->toBeNull();
});

it('can check if a field exists using array access', function () {
    $response = new ResponseObject(['foo' => 'bar']);

    expect(isset($response['foo']))->toBeTrue();
});

it('can check if a field exists using __isset', function () {
    $response = new ResponseObject(['foo' => 'bar']);

    expect($response->__isset('foo'))->toBeTrue();
});

it('throws an exception when trying to unset a field using array access', function () {
    $response = new ResponseObject(['foo' => 'bar']);

    unset($response['foo']);
})->expectException(LogicException::class);

it('throws an exception when trying to unset a field using __unset', function () {
    $response = new ResponseObject(['foo' => 'bar']);

    $response->__unset('foo');
})->expectException(LogicException::class);
