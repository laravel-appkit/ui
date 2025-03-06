<?php

namespace AppKit\UI\Components\RepeatingGroup;

use AppKit\UI\Attributes\Inheritable;
use AppKit\UI\Components\BaseComponent;
use AppKit\UI\Components\RepeatingGroup;

class AddAnotherButton extends BaseComponent
{
    /**
     * Create an instance of the component
     *
     * @param string|null $source
     */
    public function __construct(
        #[Inheritable(fromComponents: RepeatingGroup::class)]
        public ?string $source = null
    )
    {
        // constructor automatically promotes class properties
    }
}
