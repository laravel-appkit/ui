<?php

namespace AppKit\UI\Components;

class Heading extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.heading';

    public function __construct(
        public string $level,
    ) {
        $this->exposePropertyAsState('level');
    }
}
