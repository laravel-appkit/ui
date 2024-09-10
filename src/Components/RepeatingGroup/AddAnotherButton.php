<?php

namespace AppKit\UI\Components\RepeatingGroup;

use AppKit\UI\Components\BaseComponent;

class AddAnotherButton extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.repeating-group.add-another-button';

    public function __construct(
        public string $source,
    ) {

    }
}
