<?php

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Tests\Components\HigherOrderTestComponent;

beforeEach(function () {
    // we need to register the component
    Blade::component(HigherOrderTestComponent::class, 'test-component');
});

it('creates an component builder when a component is rendered', function () {
    // render a component
    $this->blade('<x-test-component foo="bar" />');

    // get the instance of the component that was rendered
    $instance = HigherOrderTestComponent::lastInstance();

    // check that we have created an component builder, with the correct properties and values
    expect($instance)->toHaveProperty('componentBuilder');
    expect($instance->getAttributeBuilder())->toBeInstanceOf(ComponentBuilder::class);
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
