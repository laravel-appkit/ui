<?php

it('can define the value of an attribute based on a state value', function ($size) {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder();

    // set the size to be small
    addSizeStateToAttributeBuilder($attributeBuilder, $size);

    // get the values of the attribute
    $values = [
        'sm' => 'small',
        'md' => 'medium',
        'lg' => 'large',
    ];

    // add the class to the attribute builder
    $attributeBuilder->setAttribute('foo', $values, state: 'size');

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->toHaveKey('foo', $values[$size]);
})->with(['sm', 'md', 'lg']);

it('can define the value of an attribute based on a state value via a magic method', function ($size) {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder();

    // set the size to be small
    addSizeStateToAttributeBuilder($attributeBuilder, $size);

    // get the values of the attribute
    $values = [
        'sm' => 'small',
        'md' => 'medium',
        'lg' => 'large',
    ];

    // add the class to the attribute builder
    $attributeBuilder->setAttributeForSize('foo', $values);

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->toHaveKey('foo', $values[$size]);
})->with(['sm', 'md', 'lg']);
