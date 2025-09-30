<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\State;

class Heading extends BaseComponent
{
    /**
     * Create an instance of the component
     *
     * @param string $level
     */
    public function __construct(
        #[State]
        public string $level,
    ) {
        // constructor promotion handles the rest
    }
}
