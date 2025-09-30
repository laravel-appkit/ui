<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\State;

class App extends BaseComponent
{
    /**
     * Create an instance of the component
     */
    public function __construct(
        #[State]
        public string $accent = 'teal',
    ) {
        // constructor promotion handles the rest
    }
}
