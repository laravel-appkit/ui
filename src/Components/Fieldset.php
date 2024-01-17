<?php

namespace AppKit\UI\Components;

class Fieldset extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.fieldset';

    public function __construct(
        public string $legend,
    ) {

    }
}
