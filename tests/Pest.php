<?php

use AppKit\UI\ComponentBuilder;
use Illuminate\View\ComponentAttributeBag;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(AppKit\UI\Tests\TestCase::class)->in('.');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Create an instance of an component builder
 *
 * @param array $attributes
 * @param array $options
 * @return ComponentBuilder
 */
function createComponentBuilder($attributes = [], $elements = [])
{
    // create an attribute bag that will be passed to the component builder
    $attributeBag = new ComponentAttributeBag($attributes);

    // return the component builder
    return new ComponentBuilder($attributeBag, $elements);
}

function addDataAttributeHelperToComponentBuilder()
{
    ComponentBuilder::registerAttributeHelper('data', function ($attribute, $value) {
        return ['data-' . $attribute => $value];
    });
}

function addStatesToComponentBuilder(ComponentBuilder $componentBuilder)
{
    $componentBuilder->registerState('true', fn () => true);
    $componentBuilder->registerState('false', fn () => false);

}

function addSizeStateToComponentBuilder(ComponentBuilder $componentBuilder, $size)
{
    $componentBuilder->registerState('size', fn () => $size);
}
