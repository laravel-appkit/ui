<?php

/**
 * The various tests that we use to test adding classes to an component builder
 */
$classData = [
    ['as a single string', 'class-1 class-2 class-3 class-4 class-5'],
    ['as an array', ['class-1', 'class-2', 'class-3', 'class-4', 'class-5']],
    ['as a nested array', [['class-1', 'class-2'], ['class-3', 'class-4', 'class-5']]],
    ['in a mixed way', ['class-1 class-2', 'class-3', ['class-4', 'class-5']]],
];

it('can be initialised with an empty attribute bag', function () {
    // check that if we don't pass anything to the attribute bag, it's empty
    expect(createComponentBuilder()->getAttributes())->toBeEmpty();
});

it('can add classes in multiple ways', function (string $method, $data) {
    // create a new component builder
    $componentBuilder = createComponentBuilder();

    // add the class to the component builder
    $componentBuilder->addClass($data);

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->toHaveKey('class', 'class-1 class-2 class-3 class-4 class-5');
})->with($classData);

it('can add classes to the classes that already exist', function (string $method, $data) {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['class' => 'class-6']);

    // add the class to the component builder
    $componentBuilder->addClass($data);

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->toHaveKey('class', 'class-6 class-1 class-2 class-3 class-4 class-5');
})->with($classData);

it('can remove classes in multiple ways', function (string $method, $data) {
    // create a new component builder
    $componentBuilder = createComponentBuilder(['class' => 'class-1 class-2 class-3 class-4 class-5 class-6']);

    // add the class to the component builder
    $componentBuilder->removeClass($data);

    // check that the classes are correct
    expect($componentBuilder->getAttributes())->toHaveKey('class', 'class-6');
})->with($classData);
