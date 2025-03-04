<?php

use Telegram\Bot\Objects\AbstractObject;

class DummyObject extends AbstractObject {}

it('can create an object using the make method', function () {
    $object = DummyObject::make(['foo' => 'bar']);

    expect($object)->toBeInstanceOf(AbstractObject::class)
        ->and($object->jsonSerialize())->toBe(['foo' => 'bar']);
});

it('can convert the object to an array', function () {
    $object = new DummyObject(['foo' => 'bar']);
    $object->put('baz', 'qux');

    expect($object->__toArray())->toBe(['foo' => 'bar', 'baz' => 'qux']);
});

it('can convert the object to JSON', function () {
    $object = new DummyObject(['foo' => 'bar']);

    expect($object->__toJson())->toBe('{"foo":"bar"}');
});

it('can serialize the object to JSON', function () {
    $object = new DummyObject(['foo' => 'bar']);

    expect($object->jsonSerialize())->toBe(['foo' => 'bar']);
});

it('can get an iterator for the object', function () {
    $object = new DummyObject(['foo' => 'bar']);

    expect($object->getIterator())->toBeInstanceOf(ArrayIterator::class);
});

it('can get a caching iterator for the object', function () {
    $object = new DummyObject(['foo' => 'bar']);

    expect($object->getCachingIterator())->toBeInstanceOf(CachingIterator::class);
});

it('can convert the object to a string', function () {
    $object = new DummyObject(['foo' => 'bar']);

    expect((string) $object)->toBe('{"foo":"bar"}');
});

it('can get debug info for the object', function () {
    $object = new DummyObject(['foo' => 'bar']);

    expect($object->__debugInfo())->toBe(['foo' => 'bar']);
});

it('can call methods on the object', function () {
    $object = new DummyObject(['foo' => 'bar']);

    expect($object->get('foo'))->toBe('bar');
});
