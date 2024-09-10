<?php

namespace AppKit\UI\Components;

class FieldError extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.field-error';

    public function __construct(
        public ?string $name,
        public string $error,
    ) {

    }
}
