<?php

namespace AppKit\UI\Components;

class Tab extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.tab';

    public function __construct(
        public string $title
    ) {

    }
}
