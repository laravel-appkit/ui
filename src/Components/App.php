<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\ExposedAsState;

class App extends BaseComponent
{
    /**
     * Create an instance of the component
     */
    public function __construct(
        #[ExposedAsState]
        public string $accent = 'teal',
    ) {
        // constructor promotion handles the rest
    }
}
