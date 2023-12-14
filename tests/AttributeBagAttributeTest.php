<?php

it('can add an attribute', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder();

    // add the class to the attribute builder
    $attributeBuilder = $attributeBuilder->setAttribute('foo', 'bar');

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->toHaveKey('foo', 'bar');
});


it('can change the value of an existing attribute', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(['foo' => 'bar']);

    // add the class to the attribute builder
    $attributeBuilder = $attributeBuilder->setAttribute('foo', 'bat');

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->toHaveKey('foo', 'bat');
});

it('can remove an existing attribute', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(['foo' => 'bar']);

    // add the class to the attribute builder
    $attributeBuilder = $attributeBuilder->removeAttribute('foo');

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->not()->toHaveKey('foo');
});

it('can remove multiple existing attributes via an array', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(['foo' => 'bar', 'bat' => 'buz']);

    // add the class to the attribute builder
    $attributeBuilder = $attributeBuilder->removeAttribute(['foo', 'bat']);

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->not()->toHaveKeys(['foo', 'bat']);
});

it('can remove multiple existing attributes via an multiple parameters', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(['foo' => 'bar', 'bat' => 'buz']);

    // add the class to the attribute builder
    $attributeBuilder = $attributeBuilder->removeAttribute('foo', 'bat');

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->not()->toHaveKeys(['foo', 'bat']);
});

it('can add an attribute via a magic method', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder();

    // add the class to the attribute builder
    $attributeBuilder = $attributeBuilder->setFooAttribute('bar');

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->toHaveKey('foo', 'bar');
});

it('can remove an attribute via a magic method', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(['foo' => 'bar']);

    // add the class to the attribute builder
    $attributeBuilder = $attributeBuilder->removeFooAttribute();

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->not()->toHaveKey('foo');
});
