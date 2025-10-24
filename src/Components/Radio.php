<?php

namespace AppKit\UI\Components;

class Radio extends BaseComponent
{
    /**
     * Create an instance of the component
     *
     * @param string $id
     * @param string|null $help
     * @param string $label
     * @param string $name
     * @param string $value
     */
    public function __construct(
        public string $id,
        public string $label,
        public string $name,
        public string $value,
        public ?string $help = null,
    ) {
        // constructor promotion handles the rest
    }
}
