<?php

/**
 * The various tests that we use to test adding classes to an attribute builder
 */
$classData = [
    ['as a single string', 'class-1 class-2 class-3 class-4 class-5'],
    ['as an array', ['class-1', 'class-2', 'class-3', 'class-4', 'class-5']],
    ['as a nested array', [['class-1', 'class-2'], ['class-3', 'class-4', 'class-5']]],
    ['in a mixed way', ['class-1 class-2', 'class-3', ['class-4', 'class-5']]],
];

it('can be initialised with an empty attribute bag', function () {
    // check that if we don't pass anything to the attribute bag, it's empty
    expect(createAttributeBuilder()->getAttributes())->toBeEmpty();
});

it('can add classes in multiple ways', function (string $method, $data) {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder();

    // add the class to the attribute builder
    $attributeBuilder->addClass($data);

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->toHaveKey('class', 'class-1 class-2 class-3 class-4 class-5');
})->with($classData);

it('can add classes to the classes that already exist', function (string $method, $data) {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(['class' => 'class-6']);

    // add the class to the attribute builder
    $attributeBuilder->addClass($data);

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->toHaveKey('class', 'class-6 class-1 class-2 class-3 class-4 class-5');
})->with($classData);

it('can remove classes in multiple ways', function (string $method, $data) {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(['class' => 'class-1 class-2 class-3 class-4 class-5 class-6']);

    // add the class to the attribute builder
    $attributeBuilder->removeClass($data);

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->toHaveKey('class', 'class-6');
})->with($classData);
