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

it('can add an attribute via parameter', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add the class to the component builder
    $componentBuilder->foo = 'bar';

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->toHaveKey('foo', 'bar');
});

it('can add a kebab case attribute via parameter', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add the class to the component builder
    $componentBuilder->ariaLabel = 'bar';

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->toHaveKey('aria-label', 'bar');
});

it('can remove an attribute via a null parameter value', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['foo' => 'bar']);

    // add the class to the component builder
    $componentBuilder->foo = null;

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->not()->toHaveKey('foo');
});

it('can remove a kebab attribute via a null parameter value', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['aria-label' => 'bar']);

    // add the class to the component builder
    $componentBuilder->ariaLabel = null;

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->not()->toHaveKey('aria-label');
});

it('can remove an attribute via an unset parameter', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['foo' => 'bar']);

    // add the class to the component builder
    unset($componentBuilder->foo);

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->not()->toHaveKey('foo');
});

it('can remove a kebab attribute via an unset parameter', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['aria-label' => 'bar']);

    // add the class to the component builder
    unset($componentBuilder->ariaLabel);

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->not()->toHaveKey('aria-label');
});

it('can access an attribute value via parameter', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['foo' => 'bar']);

    // check that the classes are correct
    expect($componentBuilder->foo)->toBe('bar');
});

it('can access a kebab attribute value via parameter', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['aria-label' => 'bar']);

    // check that the classes are correct
    expect($componentBuilder->ariaLabel)->toBe('bar');
});

it('can add an attribute via array notation', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add the class to the component builder
    $componentBuilder['foo'] = 'bar';

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->toHaveKey('foo', 'bar');
});

it('can remove an attribute via array notation', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['foo' => 'bar']);

    // add the class to the component builder
    unset($componentBuilder['foo']);

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->not()->toHaveKey('foo');
});

it('can access an attribute value via array notation', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['foo' => 'bar']);

    // check that the classes are correct
    expect($componentBuilder['foo'])->toBe('bar');
});
