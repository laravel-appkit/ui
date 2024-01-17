<?php

namespace AppKit\UI\Components;

class HelpText extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.help-text';

    public function __construct(
        public string $text,
    ) {

    }
}
