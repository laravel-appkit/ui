<?php

namespace AppKit\UI\Components;

class Input extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.input';

    public $wrapperElement;

    public function __construct(
        public string $width = 'md',
        public string $prefix = '',
        public string $postfix = '',
    ) {
        $this->exposePropertyAsState('width');

        $this->defineState('hasPrefix', function () {
            return !empty($this->prefix);
        });

        $this->defineState('hasPostfix', function () {
            return !empty($this->postfix);
        });

        $this->defineState('hasAffix', function () {
            return !empty($this->prefix) || !empty($this->postfix);
        });

        $this->wrapperElement = $this->registerAttributeBuilderElement('wrapper');
    }
}
