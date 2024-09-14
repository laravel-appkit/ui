<?php

namespace AppKit\UI\Components\RepeatingGroup;

use AppKit\UI\Attributes\Inheritable;
use AppKit\UI\Components\BaseComponent;
use AppKit\UI\Components\RepeatingGroup;
use AppKit\UI\Components\Traits\InteractsWithComponentStack;

class RemoveButton extends BaseComponent
{
    use InteractsWithComponentStack;

    /**
     * {@inheritDoc}
     */
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.repeating-group.remove-button';

    /**
     * Construct a Remove Button component
     *
     * @param string|null $source The javascript/alpine path that is being iterated
     */
    public function __construct(
        #[Inheritable(fromComponents: RepeatingGroup::class)]
        public ?string $source = null
    )
    {
        // constructor automatically promotes class properties
    }
}
