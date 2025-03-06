<?php

namespace AppKit\UI\Components;

class Checkbox extends BaseComponent
{
    /**
     * Create an instance of the component
     *
     * @param string|null $help
     * @param string $id
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
