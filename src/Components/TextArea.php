<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\Element;
use AppKit\UI\Attributes\State;
use AppKit\UI\ElementAttributeBag;

class TextArea extends BaseComponent
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
     * @param bool $hasError
     * @param string $width
     */
    public function __construct(
        #[State]
        public bool $hasError = false,
        #[State]
        public string $width = 'md',
    ) {
        // constructor promotion handles the rest
    }
}
