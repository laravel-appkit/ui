<?php

namespace AppKit\UI\Components\RepeatingGroup;

use AppKit\UI\Components\BaseComponent;
use AppKit\UI\Components\RepeatingGroup;
use AppKit\UI\Components\Traits\InteractsWithComponentStack;

class RemoveButton extends BaseComponent
{
    use InteractsWithComponentStack;

    /**
     * {@inheritDoc}
     */
    protected $viewName = 'appkit-ui::components.repeating-group.remove-button';

    /**
     * Construct a Remove Button component
     *
     * @param string|null $source The javascript/alpine path that is being iterated
     */
    public function __construct(public ?string $source = null)
    {
        // constructor automatically promotes class properties
    }

    /**
     * Prepare the component for rendering
     *
     * @return void
     */
    public function build(): void
    {
        // if we already have a source, we don't need to do anything
        if (is_null($this->source)) {
            // find the closes Repeating Group component
            $repeatingGroup = $this->closest(RepeatingGroup::class, true);

            // use the parent as the source
            $this->source = $repeatingGroup->source;
        }
    }
}
