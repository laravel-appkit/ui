<?php

namespace AppKit\UI\Components;

class HelpText extends BaseComponent
{
    /**
     * Create an instance of the component
     *
     * @param string $help
     */
    public function __construct(
        public string $help,
    ) {
        // constructor promotion handles the rest
    }
}
