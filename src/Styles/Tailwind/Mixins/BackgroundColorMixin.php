<?php

namespace AppKit\UI\Styles\Tailwind\Mixins;

use AppKit\UI\ComponentBuilder;
use InvalidArgumentException;

class BackgroundColorMixin extends BaseMixin
{
    /**
     * Invoke the mixin
     *
     * @param ComponentBuilder $component
     * @return void
     * @throws InvalidArgumentException
     */
    public function __invoke(ComponentBuilder $component): void
    {
        // get the colour that we want to apply
        $color = $component->getStateValue('color');

        $component->addClass(
            $this->tailwind->getColorClasses($color, include: ['hover', 'outline', 'text'])
        );
    }
}
