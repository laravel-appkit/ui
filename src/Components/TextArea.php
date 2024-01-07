<?php

namespace AppKit\UI\Components;

class TextArea extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.text-area';

    public $wrapperElement;

    public function __construct(
        public string $width = 'md',
    ) {
        $this->exposePropertyAsState('width');
    }
}
