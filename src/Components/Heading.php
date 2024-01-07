<?php

namespace AppKit\UI\Components;

class Heading extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.heading';

    public function __construct(
        public string $level,
    ) {
        $this->exposePropertyAsState('level');
    }
}
