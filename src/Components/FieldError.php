<?php

namespace AppKit\UI\Components;

class FieldError extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.field-error';

    public function __construct(
        public string $error,
    ) {

    }
}
