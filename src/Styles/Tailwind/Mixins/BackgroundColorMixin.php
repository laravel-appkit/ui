<?php

namespace AppKit\UI\Styles\Tailwind\Mixins;

use AppKit\UI\AttributeBuilder;
use AppKit\UI\Styles\Tailwind\Tailwind;
use InvalidArgumentException;

class BackgroundColorMixin extends BaseMixin
{
    /**
     * Invoke the mixin
     *
     * @param AttributeBuilder $attributes
     * @return void
     * @throws InvalidArgumentException
     */
    function __invoke(AttributeBuilder $attributes): void
    {
        // get the colour that we want to apply
        $color = $attributes->getStateValue('color');

        $attributes->addClass(
            $this->tailwind->getColorClasses($color, includeText: true, includeHover: true)
        );
    }
}
