<?php

namespace AppKit\UI\Tests\Components;

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
    public $labelAttributes;

    /**
     * Build the component
     *
     * @return void
     */
    public function __construct(public bool $toggle = false, public string $size = '')
    {
        $this->labelAttributes = $this->registerAttributeBuilderElement('label');

        $this->exposePropertyAsState('toggle');
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
