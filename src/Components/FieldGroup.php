<?php

namespace AppKit\UI\Components;

class FieldGroup extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.field-group';

    public $labelElement;
    public $inputWrapperElement;
    public $errorElement;
    public $helpElement;

    public function __construct(
        public ?string $name = '',
        public ?string $label = '',
        public ?string $help = '',
        public ?string $error = '',
    ) {
        $this->labelElement = $this->registerAttributeBuilderElement('label');
        $this->inputWrapperElement = $this->registerAttributeBuilderElement('wrapper');
        $this->errorElement = $this->registerAttributeBuilderElement('error');
        $this->helpElement = $this->registerAttributeBuilderElement('help');
    }
}
