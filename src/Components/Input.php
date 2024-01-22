<?php

namespace AppKit\UI\Components;

class Input extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.input';

    public $wrapperElement;

    public function __construct(
        public string $name,
        public string $postfix = '',
        public string $prefix = '',
        public string $type = 'text',
        public string $width = 'md',
        public string $id = '',
        public bool $hasError = false,
    ) {
        $this->exposePropertyAsState('width');

        $this->exposePropertyAsState('hasError');

        $this->defineState('hasPrefix', function () {
            return !empty($this->prefix);
        });

        $this->defineState('hasPostfix', function () {
            return !empty($this->postfix);
        });

        $this->defineState('hasAffix', function () {
            return !empty($this->prefix) || !empty($this->postfix);
        });

        $this->defineState('isCheckbox', function () {
            return $this->type === 'checkbox';
        });

        $this->defineState('isRadioButton', function () {
            return $this->type === 'radio';
        });

        $this->defineState('isCheckable', function () {
            return $this->type === 'checkbox' || $this->type === 'radio';
        });

        $this->wrapperElement = $this->registerAttributeBuilderElement('wrapper');

        if (!$this->id) {
            $this->id = $this->name;
        }
    }

    public function parentSet()
    {
        if ($this->parentComponent->error) {
            $this->hasError = true;
        }
    }
}
