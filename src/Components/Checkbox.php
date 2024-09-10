<?php

namespace AppKit\UI\Components;

class Checkbox extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.checkbox';

    public function __construct(
        public string $name,
        public string $value,
        public string $id,
        public string $label,
        public ?string $help = null,
    ) {

    }
}
