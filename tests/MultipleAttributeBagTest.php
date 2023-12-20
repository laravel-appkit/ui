<?php

it('can register and use multiple attribute bags', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(elements: ['label']);

    // add the class to the attribute builder
    $attributeBuilder->setAttribute('foo', 'bar', element: 'label');

    // check that the attribute is in the label attribute bag
    expect($attributeBuilder->getAttributeBag('label')->getAttributes())->toHaveKey('foo', 'bar');

    // check that the attribute has not been added to the default attribute bag
    expect($attributeBuilder->getAttributes())->not()->toHaveKey('foo', 'bar');
});

it('can have element attributes defined when creating the builder', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(attributes: ['label:foo' => 'bar'], elements: ['label']);

    // check that the attribute is in the label attribute bag
    expect($attributeBuilder->getAttributeBag('label')->getAttributes())->toHaveKey('foo', 'bar');

    // check that the attribute has not been added to the default attribute bag
    expect($attributeBuilder->getAttributes())->not()->toHaveKey('foo', 'bar');
});

it('can remove attributes from a particular element attribute bag', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(attributes: ['label:foo' => 'bar'], elements: ['label']);

    // remove the attribute from the attribute bag
    $attributeBuilder->removeAttribute('foo', element: 'label');

    // check that the attribute is in the label attribute bag
    expect($attributeBuilder->getAttributeBag('label')->getAttributes())->not()->toHaveKey('foo', 'bar');

    // check that the attribute has not been added to the default attribute bag
    expect($attributeBuilder->getAttributes())->not()->toHaveKey('foo', 'bar');
});

it('can use magic methods to add to a different attribute bag', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(elements: ['label']);

    // add the class to the attribute builder
    $attributeBuilder->setAttributeOnLabel('foo', 'bar');

    // check that the attribute is in the label attribute bag
    expect($attributeBuilder->getAttributeBag('label')->getAttributes())->toHaveKey('foo', 'bar');

    // check that the attribute has not been added to the default attribute bag
    expect($attributeBuilder->getAttributes())->not()->toHaveKey('foo', 'bar');
});

it('can use magic methods to remove from a different attribute bag', function () {
    // create a new attribute builder
    $attributeBuilder = createAttributeBuilder(attributes: ['label:foo' => 'bar'], elements: ['label']);

    // add the class to the attribute builder
    $attributeBuilder->removeAttributeFromLabel('foo');

    // check that the attribute is in the label attribute bag
    expect($attributeBuilder->getAttributeBag('label')->getAttributes())->not()->toHaveKey('foo', 'bar');

    // check that the attribute has not been added to the default attribute bag
    expect($attributeBuilder->getAttributes())->not()->toHaveKey('foo', 'bar');
});
