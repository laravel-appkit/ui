<?php

namespace AppKit\UI\Tests\Components;

use AppKit\UI\Attributes\Element;
use AppKit\UI\Attributes\ExposedAsState;
use AppKit\UI\Components\BaseComponent;
use AppKit\UI\ElementAttributeBag;
use Closure;
use Illuminate\View\Component;

class TestComponent extends BaseComponent
{
    /**
     * An example element attribute bag
     * @var ElementAttributeBag
     */
    #[Element('label')]
    public ?ElementAttributeBag $labelAttributes = null;

    /**
     * Build the component
     *
     * @return void
     */
    public function __construct(
        #[ExposedAsState]
        public bool $toggle = false,
        public string $size = ''
    ) {
        // constructor promotion handles the rest
    }

    /**
     * Render the component
     *
     * @return Closure
     */
    public function render()
    {
        return '';
    }
}
