<?php

namespace AppKit\UI\Components;

class Select extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.select';

    public $wrapperElement;

    public function __construct(
        public string $width = 'md',
        public bool $hasError = false,
    ) {
        $this->exposePropertyAsState('width');

        $this->exposePropertyAsState('hasError');
    }
}
