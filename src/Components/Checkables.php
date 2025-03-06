<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\Element;
use AppKit\UI\ElementAttributeBag;

class Checkables extends BaseComponent
{
    /**
     * The component name that should be rendered for each of the options
     *
     * @var string
     */
    public string $itemComponentName = '';

    /**
     * Attributes to be applied to the fieldset
     *
     * @var ElementAttributeBag
     */
    #[Element('fieldset')]
    public ?ElementAttributeBag $fieldsetAttributes = null;

    /**
     * Create an instance of the component
     *
     * @param string $id
     * @param string $label
     * @param string $name
     * @param string $type
     * @param array $options
     */
    public function __construct(
        public string $id,
        public string $label,
        public string $name,
        public string $type,
        public array $options,
    ) {
        $this->itemComponentName = ($this->type == 'radio') ? 'appkit::radio' : 'appkit::checkbox';

        // constructor promotion handles the rest
    }
}
