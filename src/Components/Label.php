<?php

namespace AppKit\UI\Components;

class Label extends BaseComponent
{
    /**
     * Create an instance of the component
     *
     * @param string $for
     * @param string $label
     * @param boolean $required
     */
    public function __construct(
        public string $for,
        public string $label,
        public bool $required = false,
    ) {
        // constructor promotion handles the rest
    }
}
