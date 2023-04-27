<?php

use Telegram\Bot\Objects\ResponseObject;

it('recursively converts stdClass to ResponseObjects', function () {
    // Create an example stdClass object with nested objects
    $object = new stdClass();
    $object->name = 'John';
    $object->age = 30;
    $object->address = new stdClass();
    $object->address->street = '123 Main St';
    $object->address->city = 'Anytown';

// Create a new instance of MyStdClass with the object
    $response = new ResponseObject($object);

    expect($response)->toBeInstanceOf(ResponseObject::class);
    expect($response->address)->toBeInstanceOf(ResponseObject::class);
    expect($response->address->street)->toBe('123 Main St');
});

it('can accept an array of stdClasses or a single stdClass and returns a ResponseObject', function () {
    // Create a stdClass object with nested stdClass objects
    $stdObject = new stdClass();
    $stdObject->name = 'John';
    $stdObject->age = 25;
    $stdObject->address = new stdClass();
    $stdObject->address->street = '123 Main St';
    $stdObject->address->city = 'Anytown';
    $stdObject->address->state = 'CA';
    $stdObject->address->zip = '12345';

    // Create an array of stdClass objects
    $stdArray = [
        new stdClass(),
        new stdClass(),
    ];
    $stdArray[0]->name = 'Jane';
    $stdArray[0]->age = 30;
    $stdArray[0]->address = new stdClass();
    $stdArray[0]->address->street = '456 Oak St';
    $stdArray[0]->address->city = 'Anytown';
    $stdArray[0]->address->state = 'CA';
    $stdArray[0]->address->zip = '12345';
    $stdArray[1]->name = 'Bob';
    $stdArray[1]->age = 40;
    $stdArray[1]->address = new stdClass();
    $stdArray[1]->address->street = '789 Pine St';
    $stdArray[1]->address->city = 'Anytown';
    $stdArray[1]->address->state = 'CA';
    $stdArray[1]->address->zip = '12345';

    // Test with a single stdClass object
    $response1 = new ResponseObject($stdObject);

    expect($response1->name)->toBe('John');
    expect($response1->address)->toBeInstanceOf(ResponseObject::class);
    expect($response1->address->street)->toBe('123 Main St');
    expect($response1->address->city)->toBe('Anytown');
    expect($response1->address->state)->toBe('CA');
    expect($response1->address->zip)->toBe('12345');

    // Test with an array of stdClass objects
    $response2 = new ResponseObject($stdArray);

    expect($response2[0]->name)->toBe('Jane');
    expect($response2[0]->address)->toBeInstanceOf(ResponseObject::class);
    expect($response2[0]->address->street)->toBe('456 Oak St');
    expect($response2[0]->address->city)->toBe('Anytown');
    expect($response2[0]->address->state)->toBe('CA');
    expect($response2[0]->address->zip)->toBe('12345');

    expect($response2[1]->name)->toBe('Bob');
    expect($response2[1]->address)->toBeInstanceOf(ResponseObject::class);
    expect($response2[1]->address->street)->toBe('789 Pine St');
    expect($response2[1]->address->city)->toBe('Anytown');
    expect($response2[1]->address->state)->toBe('CA');
    expect($response2[1]->address->zip)->toBe('12345');
});
