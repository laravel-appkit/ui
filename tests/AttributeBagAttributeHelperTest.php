<?php


it('can have attribute helpers which modify the attributes being set', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder();

    // add in the data helper
    addDataAttributeHelperToAttributeBuilder();

    // add the class to the attribute builder
    $attributeBuilder = $attributeBuilder->setAttribute('foo', 'bar', 'data');

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->toHaveKey('data-foo', 'bar');
});

it('can use attribute helpers via the magic method', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder();

    // add in the data helper
    addDataAttributeHelperToAttributeBuilder();

    // add the class to the attribute builder
    $attributeBuilder = $attributeBuilder->setDataAttribute('foo', 'bar');

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->toHaveKey('data-foo', 'bar');
});

it('can use attribute helpers and attribute name via the magic method', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder();

    // add in the data helper
    addDataAttributeHelperToAttributeBuilder();

    // add the class to the attribute builder
    $attributeBuilder = $attributeBuilder->setDataFooAttribute('bar');

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->toHaveKey('data-foo', 'bar');
});

it('can have attribute helpers which modify the attributes being removed', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(['data-foo' => 'bar']);

    // add in the data helper
    addDataAttributeHelperToAttributeBuilder();

    // add the class to the attribute builder
    $attributeBuilder = $attributeBuilder->removeAttribute('foo', 'data');

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->not()->toHaveKey('data-foo');
});

it('can use attribute helpers to remove via the magic method', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(['data-foo' => 'bar']);

    // add in the data helper
    addDataAttributeHelperToAttributeBuilder();

    // add the class to the attribute builder
    $attributeBuilder = $attributeBuilder->removeDataAttribute('foo');

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->not()->toHaveKey('data-foo');
});

it('can use attribute helpers and attribute name to remove via the magic method', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(['data-foo' => 'bar']);

    // add in the data helper
    addDataAttributeHelperToAttributeBuilder();

    // add the class to the attribute builder
    $attributeBuilder = $attributeBuilder->removeDataFooAttribute();

    // check that the classes are correct
    expect($attributeBuilder->getAttributes())->not()->toHaveKey('data-foo');
});
