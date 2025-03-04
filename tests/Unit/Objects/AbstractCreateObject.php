<?php

use Telegram\Bot\Objects\AbstractCreateObject;
use Telegram\Bot\Objects\ResponseObject;

class DummyCreateObject extends AbstractCreateObject {}

it('can create an object using the make method', function () {
    $object = DummyCreateObject::make(['foo' => 'bar']);

    expect($object)->toBeInstanceOf(DummyCreateObject::class)
        ->and($object->__toArray())->toBe(['foo' => 'bar']);
});

it('can set fields using magic methods', function () {
    $object = new DummyCreateObject;
    $object->foo('bar');
    $object->baz(['qux' => 'quux']);

    expect($object->__toArray())->toBe(['foo' => 'bar', 'baz' => ['qux' => 'quux']]);
});

it('can set fields using constructor', function () {
    $object = new DummyCreateObject(['foo' => 'bar', 'baz' => ['qux' => 'quux']]);

    expect($object->__toArray())->toBe(['foo' => 'bar', 'baz' => ['qux' => 'quux']]);
});

it('can set fields using array', function () {
    $object = new DummyCreateObject;
    $object->baz(['qux' => 'quux']);

    expect($object->__toArray())->toBe(['baz' => ['qux' => 'quux']]);
});

it('can set fields using abstract object', function () {
    $object = new DummyCreateObject;
    $object->foo('bar');
    $object->baz(new ResponseObject(['qux' => 'quux']));

    expect($object->__toArray())->toBe(['foo' => 'bar', 'baz' => ['qux' => 'quux']]);
});

it('sets fields in snake case', function () {
    $object = new DummyCreateObject;
    $object->fooBar('test');
    $object->someLongFieldName('bar');

    expect($object->__toArray())->toBe(['foo_bar' => 'test', 'some_long_field_name' => 'bar']);
});

it('can call methods on the object', function () {
    $object = new DummyCreateObject(['foo' => 'bar']);

    expect($object->get('foo'))->toBe('bar');
});
