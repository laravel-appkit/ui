<?php

namespace AppKit\UI\Components;

class FieldGroup extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.field-group';

    public function __construct(
        public ?string $label = '',
        public ?string $help = '',
        public ?string $error = '',
    ) {

    }
}
