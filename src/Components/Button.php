<?php

namespace AppKit\UI\Components;

class Button extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.button';

    public function __construct(
        public string $color = 'red',
        public string $size = 'md',
        public string $shape = 'rounded',
    )
    {
        $this->exposePropertyAsState('color');
        $this->exposePropertyAsState('size');
        $this->exposePropertyAsState('shape');
    }
}
