<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\Element;
use AppKit\UI\Attributes\State;
use AppKit\UI\ElementAttributeBag;

class Select extends BaseComponent
{
    /**
     * The attributes that get applied to the wrapper
     *
     * @var ElementAttributeBag|null
     */
    #[Element('wrapper')]
    public ?ElementAttributeBag $wrapperElement = null;

    /**
     * Create an instance of the component
     *
     * @param string $width
     * @param bool $hasError
     */
    public function __construct(
        #[State]
        public string $width = 'md',
        #[State]
        public bool $hasError = false,
    ) {
        // constructor promotion handles the rest
    }
}
