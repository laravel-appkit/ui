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
     * Example boolean property that can be set on the component
     * @var bool
     */
    public bool $toggle = false;

    /**
     * Example string property that can be set on the component
     * @var string
     */
    public string $size = '';

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
    public function __construct($toggle = false, $size = '')
    {
        $this->toggle = $toggle;
        $this->size = $size;

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
        return function ($data) {
            $data = $this->runAttributeBuilder($data);
        };
    }
}
