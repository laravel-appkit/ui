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
