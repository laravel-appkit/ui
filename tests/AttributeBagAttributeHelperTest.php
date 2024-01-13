<?php

it('can have attribute helpers which modify the attributes being set', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add in the data helper
    addDataAttributeHelperToComponentBuilder();

    // add the class to the component builder
    $componentBuilder->setAttribute('foo', 'bar', 'data');

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->toHaveKey('data-foo', 'bar');
});

it('can use attribute helpers via the magic method', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add in the data helper
    addDataAttributeHelperToComponentBuilder();

    // add the class to the component builder
    $componentBuilder->setDataAttribute('foo', 'bar');

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->toHaveKey('data-foo', 'bar');
});

it('can use attribute helpers and attribute name via the magic method', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add in the data helper
    addDataAttributeHelperToComponentBuilder();

    // add the class to the component builder
    $componentBuilder->setDataFooAttribute('bar');

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->toHaveKey('data-foo', 'bar');
});

it('can have attribute helpers which modify the attributes being removed', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['data-foo' => 'bar']);

    // add in the data helper
    addDataAttributeHelperToComponentBuilder();

    // add the class to the component builder
    $componentBuilder->removeAttribute('foo', 'data');

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->not()->toHaveKey('data-foo');
});

it('can use attribute helpers to remove via the magic method', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['data-foo' => 'bar']);

    // add in the data helper
    addDataAttributeHelperToComponentBuilder();

    // add the class to the component builder
    $componentBuilder->removeDataAttribute('foo');

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->not()->toHaveKey('data-foo');
});

it('can use attribute helpers and attribute name to remove via the magic method', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['data-foo' => 'bar']);

    // add in the data helper
    addDataAttributeHelperToComponentBuilder();

    // add the class to the component builder
    $componentBuilder->removeDataFooAttribute();

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->not()->toHaveKey('data-foo');
});
