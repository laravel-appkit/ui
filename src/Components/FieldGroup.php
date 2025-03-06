<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\Element;
use AppKit\UI\ElementAttributeBag;

class FieldGroup extends BaseComponent
{
    /**
     * Attributes to be applied to the element
     *
     * @var ElementAttributeBag
     */
    #[Element('label')]
    public ?ElementAttributeBag $labelAttributes = null;

    /**
     * Attributes to be applied around the field
     *
     * @var ElementAttributeBag
     */
    #[Element('field')]
    public ?ElementAttributeBag $fieldAttributes = null;

    /**
     * Attributes to be applied to the error message
     *
     * @var ElementAttributeBag
     */
    #[Element('error')]
    public ?ElementAttributeBag $errorAttributes = null;

    /**
     * Attributes to be applied to the help text
     *
     * @var ElementAttributeBag
     */
    #[Element('help')]
    public ?ElementAttributeBag $helpAttributes = null;

    /**
     * Create an instance of the component
     *
     * @param string|null $error
     * @param string|null $help
     * @param string|null $label
     * @param string|null $name
     * @param boolean $required
     */
    public function __construct(
        public ?string $error = '',
        public ?string $help = '',
        public ?string $label = '',
        public ?string $name = '',
        public bool $required = false,
    ) {
        // constructor promotion handles the rest
    }
}
