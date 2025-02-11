<?php

namespace AppKit\UI\Components;

class Label extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.label';

    public function __construct(
        public string $for,
        public string $label,
        public bool $required = false,
    ) {

    }
}
