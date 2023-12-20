<?php

use AppKit\UI\Tests\Components\HigherOrderTestComponent;

beforeEach(function () {
    Blade::component(HigherOrderTestComponent::class, 'test-component');
});

it('integrates with components', function () {
    $blade = $this->blade('<x-test-component property="foo" class="bar" />');

    expect($blade)->not()->toBeEmpty();
});
