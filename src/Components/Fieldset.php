<?php

namespace AppKit\UI\Components;

use AppKit\UI\ElementAttributeBag;

class Fieldset extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.fieldset';

    public function __construct(
        public string $legend,
        public array|ElementAttributeBag|null $inheritedAttributes = null,
    ) {

    }

    public function build()
    {
        if (is_a($this->inheritedAttributes, ElementAttributeBag::class)) {
            $this->inheritedAttributes = $this->inheritedAttributes->attributes();
        }
    }
}
