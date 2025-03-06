<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\ExposedAsState;

class Heading extends BaseComponent
{
    /**
     * Create an instance of the component
     *
     * @param string $level
     */
    public function __construct(
        #[ExposedAsState]
        public string $level,
    ) {
        // constructor promotion handles the rest
    }
}
