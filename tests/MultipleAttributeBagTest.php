<?php

it('can register and use multiple elements', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(elements: ['label']);

    // add the class to the component builder
    $componentBuilder->element('label')->setAttribute('foo', 'bar');

    // check that the attribute is in the label attribute bag
    expect($componentBuilder->getAttributeBag('label')->getAttributes())->toHaveKey('foo', 'bar');

    // check that the attribute has not been added to the default attribute bag
    expect($componentBuilder->getAttributes())->not()->toHaveKey('foo', 'bar');
});

it('can have element attributes defined when creating the builder', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(attributes: ['label:foo' => 'bar'], elements: ['label']);

    // check that the attribute is in the label attribute bag
    expect($componentBuilder->getAttributeBag('label')->getAttributes())->toHaveKey('foo', 'bar');

    // check that the attribute has not been added to the default attribute bag
    expect($componentBuilder->getAttributes())->not()->toHaveKey('foo', 'bar');
});

it('can remove attributes from a particular element', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(attributes: ['label:foo' => 'bar'], elements: ['label']);

    // remove the attribute from the attribute bag
    $componentBuilder->element('label')->removeAttribute('foo');

    // check that the attribute is in the label attribute bag
    expect($componentBuilder->getAttributeBag('label')->getAttributes())->not()->toHaveKey('foo', 'bar');

    // check that the attribute has not been added to the default attribute bag
    expect($componentBuilder->getAttributes())->not()->toHaveKey('foo', 'bar');
});

it('can use magic methods to add to a different element', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(elements: ['label']);

    // add the class to the component builder
    $componentBuilder->setAttributeOnLabel('foo', 'bar');

    // check that the attribute is in the label attribute bag
    expect($componentBuilder->getAttributeBag('label')->getAttributes())->toHaveKey('foo', 'bar');

    // check that the attribute has not been added to the default attribute bag
    expect($componentBuilder->getAttributes())->not()->toHaveKey('foo', 'bar');
});

it('can use magic methods to remove from a different element', function () {
    // create a new component builder
    $componentBuilder = createComponentBuilder(attributes: ['label:foo' => 'bar'], elements: ['label']);

    // add the class to the component builder
    $componentBuilder->removeAttributeFromLabel('foo');

    // check that the attribute is in the label attribute bag
    expect($componentBuilder->getAttributeBag('label')->getAttributes())->not()->toHaveKey('foo', 'bar');

    // check that the attribute has not been added to the default attribute bag
    expect($componentBuilder->getAttributes())->not()->toHaveKey('foo', 'bar');
});
