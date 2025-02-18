<?php

namespace AppKit\UI\Components;

class Icon extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.icon';

    public function __construct(
        public ?string $icon = null,
    ) {

    }
}
