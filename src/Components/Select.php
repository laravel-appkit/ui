<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\Element;
use AppKit\UI\Attributes\ExposedAsState;
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
     * @param boolean $hasError
     */
    public function __construct(
        #[ExposedAsState]
        public string $width = 'md',

        #[ExposedAsState]
        public bool $hasError = false,
    ) {
        // constructor promotion handles the rest
    }
}
