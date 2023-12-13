<?php

use AppKit\UI\AttributeBuilder;
use Illuminate\View\ComponentAttributeBag;

uses(\AppKit\UI\Tests\TestCase::class);

beforeEach(function () {
    $attributeBag = new ComponentAttributeBag();

    $this->attributeBuilder = new AttributeBuilder($attributeBag, collect());
});

it('can be initialised with an empty attribute bag', function () {
    expect($this->attributeBuilder->getAttributeBag()->jsonSerialize())->toBeEmpty();
});

it('can add classes in multiple ways', function (string $method, $data) {
    $attributeBuilder = $this->attributeBuilder->addClass($data);

    expect($attributeBuilder->getAttributeBag()->jsonSerialize())->toHaveKey('class', 'class-1 class-2 class-3 class-4 class-5');
})->with([
    ['as a single string', 'class-1 class-2 class-3 class-4 class-5'],
    ['as an array', ['class-1', 'class-2', 'class-3', 'class-4', 'class-5']],
    ['as a nested array', [['class-1', 'class-2'], ['class-3', 'class-4', 'class-5']]],
    ['in a mixed way', ['class-1 class-2', 'class-3', ['class-4', 'class-5']]],
]);
