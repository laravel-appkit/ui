<?php

use AppKit\UI\AttributeBuilder;
use AppKit\UI\Tests\Components\HigherOrderTestComponent;

beforeEach(function () {
    // we need to register the component
    Blade::component(HigherOrderTestComponent::class, 'test-component');
});

afterEach(function () {
    // after we have run the test, we should reset the component
    HigherOrderTestComponent::resetAllCustomisations();
});

it('can apply a customisation', function () {
    HigherOrderTestComponent::customise(function (AttributeBuilder $attributes) {
        $attributes->setAttribute('foo', 'bar');
    });

    // render a component
    $this->blade('<x-test-component />');

    // get the instance of the component that was rendered
    $instance = HigherOrderTestComponent::lastInstance();

    // check that the attributes are created, and in the correct place
    expect($instance->getAttributeBuilder()->getAttributes())->toHaveKey('foo', 'bar');
});

it('can apply multiple customisations', function () {
    HigherOrderTestComponent::customise(function (AttributeBuilder $attributes) {
        $attributes->setAttribute('foo', 'bar');
    });

    HigherOrderTestComponent::customise(function (AttributeBuilder $attributes) {
        $attributes->setAttribute('bat', 'ball');
    });

    // render a component
    $this->blade('<x-test-component />');

    // get the instance of the component that was rendered
    $instance = HigherOrderTestComponent::lastInstance();

    // check that the attributes are created, and in the correct place
    expect($instance->getAttributeBuilder()->getAttributes())->toHaveKey('foo', 'bar');
    expect($instance->getAttributeBuilder()->getAttributes())->toHaveKey('bat', 'ball');
});

it('can apply customisations with weights', function () {
    HigherOrderTestComponent::customise(function (AttributeBuilder $attributes) {
        $attributes->setAttribute('foo', 'bar');
    });

    HigherOrderTestComponent::customise(function (AttributeBuilder $attributes) {
        $attributes->setAttribute('foo', 'ball');
    }, 20);

    // render a component
    $this->blade('<x-test-component />');

    // get the instance of the component that was rendered
    $instance = HigherOrderTestComponent::lastInstance();

    // check that the attributes are created, and in the correct place
    expect($instance->getAttributeBuilder()->getAttributes())->toHaveKey('foo', 'ball');
});

it('applies customisations in the order they were defined for equal weights', function () {
    HigherOrderTestComponent::customise(function (AttributeBuilder $attributes) {
        $attributes->setAttribute('foo', 'bar');
    });

    HigherOrderTestComponent::customise(function (AttributeBuilder $attributes) {
        $attributes->setAttribute('foo', 'bat');
    });

    // render a component
    $this->blade('<x-test-component />');

    // get the instance of the component that was rendered
    $instance = HigherOrderTestComponent::lastInstance();

    // check that the attributes are created, and in the correct place
    expect($instance->getAttributeBuilder()->getAttributes())->toHaveKey('foo', 'bat');
});

it('can pass properties down to state', function () {
    HigherOrderTestComponent::customise(function (AttributeBuilder $attributes) {
        $attributes->setAttributeWhenToggle('foo', 'bar');
    });

    // render a component
    $this->blade('<x-test-component />');

    // get the instance of the component that was rendered
    $instance = HigherOrderTestComponent::lastInstance();

    // check that the attributes are created, and in the correct place
    expect($instance->getAttributeBuilder()->getAttributes())->not()->toHaveKey('foo', 'bar');

    // render another component
    $this->blade('<x-test-component toggle="toggle" size="xs" />');

    // get the instance of the component that was rendered
    $instance = HigherOrderTestComponent::lastInstance();

    // check that the attributes are created, and in the correct place
    expect($instance->getAttributeBuilder()->getAttributes())->toHaveKey('foo', 'bar');
});
