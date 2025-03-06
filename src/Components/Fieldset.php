<?php

namespace AppKit\UI\Components;

use AppKit\UI\ElementAttributeBag;

class Fieldset extends BaseComponent
{
    /**
     * Create an instance of the component
     *
     * @param array|ElementAttributeBag|null|null $inheritedAttributes
     * @param string $legend
     */
    public function __construct(
        public array|ElementAttributeBag|null $inheritedAttributes = null,
        public string $legend,
    ) {
        // constructor promotion handles the rest
    }

    // TODO: Move this to an attribute
    public function build()
    {
        if (is_a($this->inheritedAttributes, ElementAttributeBag::class)) {
            $this->inheritedAttributes = $this->inheritedAttributes->attributes();
        }
    }
}
