<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\ExposedAsState;

class Button extends BaseComponent
{
    /**
     * Create an instance of the component
     *
     * @param string $color
     * @param string $size
     * @param string $shape
     * @param string|null $href
     */
    public function __construct(
        #[ExposedAsState]
        public string $color = 'red',

        #[ExposedAsState]
        public string $size = 'md',

        #[ExposedAsState]
        public string $shape = 'rounded',

        public ?string $href = null,
    ) {
        // constructor promotion handles the rest
    }
}
