<?php

it('can define the value of an attribute based on a state value', function ($size) {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // set the size to be small
    addSizeStateToComponentBuilder($componentBuilder, $size);

    // get the values of the attribute
    $values = [
        'sm' => 'small',
        'md' => 'medium',
        'lg' => 'large',
    ];

    // add the class to the component builder
    $componentBuilder->setAttribute('foo', $values, state: 'size');

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->toHaveKey('foo', $values[$size]);
})->with(['sm', 'md', 'lg']);

it('can define the value of an attribute based on a state value via a magic method', function ($size) {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // set the size to be small
    addSizeStateToComponentBuilder($componentBuilder, $size);

    // get the values of the attribute
    $values = [
        'sm' => 'small',
        'md' => 'medium',
        'lg' => 'large',
    ];

    // add the class to the component builder
    $componentBuilder->setAttributeForSize('foo', $values);

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->toHaveKey('foo', $values[$size]);
})->with(['sm', 'md', 'lg']);
