<?php

namespace AppKit\UI\Components;

class Checkbox extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.checkbox';

    public function __construct(
        public string $name,
        public string $value,
        public string $id,
        public string $label,
        public ?string $help = null,
    ) {

    }
}
