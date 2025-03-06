<?php

namespace AppKit\UI\Components;

class Icon extends BaseComponent
{
    /**
     * Create an instance of the component
     *
     * @param string|null $icon
     */
    public function __construct(
        public ?string $icon = null,
    ) {
        // constructor promotion handles the rest
    }
}
