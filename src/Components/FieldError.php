<?php

namespace AppKit\UI\Components;

class FieldError extends BaseComponent
{
    /**
     * Create an instance of the component
     *
     * @param string $error
     * @param string|null $name
     */
    public function __construct(
        public string $error,
        public ?string $name,
    ) {
        // constructor promotion handles the rest
    }
}
