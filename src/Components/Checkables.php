<?php

namespace AppKit\UI\Components;

use AppKit\UI\ElementAttributeBag;

class Checkables extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.checkables';

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
    public ElementAttributeBag $fieldsetAttributes;

    public function __construct(
        public string $id,
        public string $label,
        public string $name,
        public string $type,
        public array $options,
    ) {
        $this->itemComponentName = ($this->type == 'radio') ? 'appkit::radio' : 'appkit::checkbox';

        $this->fieldsetAttributes = $this->registerAttributeBuilderElement('fieldset');
    }
}
