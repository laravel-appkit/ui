<?php

namespace AppKit\UI\Components;

class Label extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.label';

    public function __construct(
        public string $for,
        public string $label,
    ) {

    }
}
