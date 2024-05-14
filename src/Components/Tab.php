<?php

namespace AppKit\UI\Components;

class Tab extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.tab';

    public function __construct(
        public string $title
    ) {

    }
}
