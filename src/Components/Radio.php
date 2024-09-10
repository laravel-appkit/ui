<?php

namespace AppKit\UI\Components;

class Radio extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.radio';

    public function __construct(
        public string $name,
        public string $value,
        public string $id,
        public string $label,
        public ?string $help = null,
    ) {

    }
}
