<?php

use AppKit\UI\AttributeBuilder;
use AppKit\UI\Tests\Components\HigherOrderTestComponent;

beforeEach(function () {
    // we need to register the component
    Blade::component(HigherOrderTestComponent::class, 'test-component');
});

it('creates an attribute builder when a component is rendered', function () {
    // render a component
    $this->blade('<x-test-component foo="bar" />');

    // get the instance of the component that was rendered
    $instance = HigherOrderTestComponent::lastInstance();

    // check that we have created an attribute builder, with the correct properties and values
    expect($instance)->toHaveProperty('attributeBuilder');
    expect($instance->getAttributeBuilder())->toBeInstanceOf(AttributeBuilder::class);
    expect($instance->getAttributeBuilder()->getAttributes())->toHaveKey('foo', 'bar');
});

it('can take in element attributes by prefix', function () {
    // render a component
    $this->blade('<x-test-component label:foo="bar" />');

    // get the instance of the component that was rendered
    $instance = HigherOrderTestComponent::lastInstance();

    // check that the attributes are created, and in the correct place
    expect($instance->getAttributeBuilder()->getAttributes())->not()->toHaveKey('foo', 'bar');
    expect($instance->getAttributeBuilder()->getAttributeBag('label')->getAttributes())->toHaveKey('foo', 'bar');
});
