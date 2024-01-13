<?php

it('can specify a condition to apply an attribute', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add the class to the component builder
    $componentBuilder
        ->setAttribute('foo', 'bar', condition: fn () => true)
        ->setAttribute('bat', 'ball', condition: fn () => false);

    // check that the classes are correct
    expect($componentBuilder->getAttributes())
        ->toHaveKey('foo', 'bar')
        ->not()->toHaveKey('bat', 'ball');
});

it('can have conditionals specified as helpers', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add the conditional helpers
    addStatesToComponentBuilder($componentBuilder);

    // add the class to the component builder
    $componentBuilder
        ->setAttribute('foo', 'bar', condition: 'true')
        ->setAttribute('bat', 'ball', condition: 'false');

    // check that the classes are correct
    expect($componentBuilder->getAttributes())
        ->toHaveKey('foo', 'bar')
        ->not()->toHaveKey('bat', 'ball');
});

it('can use conditionals in magic methods', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add the conditional helpers
    addStatesToComponentBuilder($componentBuilder);

    // add the class to the component builder
    $componentBuilder
        ->setAttributeIfTrue('foo', 'bar')
        ->setAttributeIfFalse('bat', 'ball');

    // check that the classes are correct
    expect($componentBuilder->getAttributes())
        ->toHaveKey('foo', 'bar')
        ->not()->toHaveKey('bat', 'ball');
});

it('can specify a negated condition to apply an attribute', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add the class to the component builder
    $componentBuilder
        ->setAttribute('foo', 'bar', condition: fn () => false, negateCondition: true)
        ->setAttribute('bat', 'ball', condition: fn () => true, negateCondition: true);

    // check that the classes are correct
    expect($componentBuilder->getAttributes())
        ->toHaveKey('foo', 'bar')
        ->not()->toHaveKey('bat', 'ball');
});

it('can have negated conditionals specified as helpers', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add the conditional helpers
    addStatesToComponentBuilder($componentBuilder);

    // add the class to the component builder
    $componentBuilder
        ->setAttribute('foo', 'bar', condition: 'false', negateCondition: true)
        ->setAttribute('bat', 'ball', condition: 'true', negateCondition: true);

    // check that the classes are correct
    expect($componentBuilder->getAttributes())
        ->toHaveKey('foo', 'bar')
        ->not()->toHaveKey('bat', 'ball');
});

it('can use negated conditionals in magic methods', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add the conditional helpers
    addStatesToComponentBuilder($componentBuilder);

    // add the class to the component builder
    $componentBuilder
        ->setAttributeIfNotFalse('foo', 'bar')
        ->setAttributeIfNotTrue('bat', 'ball');

    // check that the classes are correct
    expect($componentBuilder->getAttributes())
        ->toHaveKey('foo', 'bar')
        ->not()->toHaveKey('bat', 'ball');
});
