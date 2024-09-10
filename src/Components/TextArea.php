<?php

namespace AppKit\UI\Components;

class TextArea extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.text-area';

    public $wrapperElement;

    public function __construct(
        public string $width = 'md',
        public bool $hasError = false,
    ) {
        $this->exposePropertyAsState('width');

        $this->exposePropertyAsState('hasError');
    }
}
