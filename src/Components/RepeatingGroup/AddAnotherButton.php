<?php

namespace AppKit\UI\Components\RepeatingGroup;

use AppKit\UI\Components\BaseComponent;

class AddAnotherButton extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.repeating-group.add-another-button';

    public function __construct(public string $source) {

    }
}
