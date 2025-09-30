<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\Element;
use AppKit\UI\Attributes\State;
use AppKit\UI\Attributes\Slotable;
use AppKit\UI\ElementAttributeBag;

class Alert extends BaseComponent
{
    /**
     * Attributes to be applied to the error message
     *
     * @var ElementAttributeBag
     */
    #[Element('title')]
    public ?ElementAttributeBag $titleAttributes = null;

    /**
     * Attributes to be applied to the error message
     *
     * @var ElementAttributeBag
     */
    #[Element('content')]
    public ?ElementAttributeBag $contentAttributes = null;

    /**
     * Attributes to be applied to the error message
     *
     * @var ElementAttributeBag
     */
    #[Element('icon')]
    public ?ElementAttributeBag $iconAttributes = null;

    /**
     * Create an instance of the component
     *
     * @param string|null $icon
     * @param string|null $title
     * @param string|null $type
     */
    public function __construct(
        #[Slotable]
        public ?string $icon = null,
        #[Slotable]
        public ?string $title = null,
        #[State]
        public ?string $type = 'success',
    ) {
        // constructor promotion handles the rest
    }
}
