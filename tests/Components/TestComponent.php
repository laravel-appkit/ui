<?php

namespace AppKit\UI\Tests\Components;

use AppKit\UI\Components\Concerns\HasAttributeBuilder;
use AppKit\UI\ElementAttributeBagWrapper;
use Closure;
use Illuminate\View\Component;

class TestComponent extends Component
{
    use HasAttributeBuilder;

    /**
     * Example property that can be set on the component
     * @var bool
     */
    public bool $property = true;

    /**
     * An example element attribute bag
     * @var ElementAttributeBagWrapper
     */
    public $labelAttributes;

    /**
     * Build the component
     *
     * @return void
     */
    public function __construct()
    {
        $this->labelAttributes = $this->registerAttributeBuilderElement('label');
    }

    /**
     * Render the component
     *
     * @return Closure
     */
    public function render()
    {
        return function ($data) {
            $data = $this->runAttributeBuilder($data);
        };
    }
}
