<?php

namespace AppKit\UI\Components;

class HelpText extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.help-text';

    public function __construct(
        public string $help,
    ) {

    }
}
