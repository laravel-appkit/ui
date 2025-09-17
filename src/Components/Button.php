<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\ExposedAsState;

// #[AppkitComponent('button')]
// #[Slot('content', default: true)]
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
        public string $color = 'accent',
        #[ExposedAsState]
        public string $size = 'md',
        #[ExposedAsState]
        public string $shape = 'rounded',
        // #[Content]
        public ?string $href = null,
    ) {
        // constructor promotion handles the rest
    }
}

/* Example Use

public function index() {
    return Button::make()
        ->color('accent')
        ->size('md')
        ->href('https://www.google.com/');

    return Button::make(color: 'accent', size: 'md');

    return Button::make(['color' => 'accent, 'size' => 'md']);
}

*/
