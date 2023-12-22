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
     * An example element attribute bag
     * @var ElementAttributeBagWrapper
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

        $this->exposePropertyAsConditional('toggle');
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
