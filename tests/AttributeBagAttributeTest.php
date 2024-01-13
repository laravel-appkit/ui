<?php

it('can add an attribute', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add the class to the component builder
    $componentBuilder->setAttribute('foo', 'bar');

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->toHaveKey('foo', 'bar');
});

it('can change the value of an existing attribute', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['foo' => 'bar']);

    // add the class to the component builder
    $componentBuilder->setAttribute('foo', 'bat');

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->toHaveKey('foo', 'bat');
});

it('can remove an existing attribute', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['foo' => 'bar']);

    // add the class to the component builder
    $componentBuilder->removeAttribute('foo');

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->not()->toHaveKey('foo');
});

it('can remove multiple existing attributes via an array', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['foo' => 'bar', 'bat' => 'buz']);

    // add the class to the component builder
    $componentBuilder->removeAttribute(['foo', 'bat']);

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->not()->toHaveKeys(['foo', 'bat']);
});

it('can add an attribute via a magic method', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add the class to the component builder
    $componentBuilder->setFooAttribute('bar');

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->toHaveKey('foo', 'bar');
});

it('can remove an attribute via a magic method', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['foo' => 'bar']);

    // add the class to the component builder
    $componentBuilder->removeFooAttribute();

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->not()->toHaveKey('foo');
});
