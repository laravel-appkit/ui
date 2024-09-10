<?php

namespace AppKit\UI\Components;

use AppKit\UI\ElementAttributeBag;

class FieldGroup extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.field-group';

    /**
     * Attributes to be applied to the element
     *
     * @var ElementAttributeBag
     */
    public ElementAttributeBag $labelAttributes;

    /**
     * Attributes to be applied around the field
     *
     * @var ElementAttributeBag
     */
    public ElementAttributeBag $fieldAttributes;

    /**
     * Attributes to be applied to the error message
     *
     * @var ElementAttributeBag
     */
    public ElementAttributeBag $errorAttributes;

    /**
     * Attributes to be applied to the help text
     *
     * @var ElementAttributeBag
     */
    public ElementAttributeBag $helpAttributes;

    public function __construct(
        public ?string $name = '',
        public ?string $label = '',
        public ?string $help = '',
        public ?string $error = '',
    ) {
        // register the attribute builder elements
        $this->labelAttributes = $this->registerAttributeBuilderElement('label');
        $this->fieldAttributes = $this->registerAttributeBuilderElement('field');
        $this->errorAttributes = $this->registerAttributeBuilderElement('error');
        $this->helpAttributes = $this->registerAttributeBuilderElement('help');
    }
}
