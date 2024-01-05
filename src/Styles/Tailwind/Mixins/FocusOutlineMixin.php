<?php

namespace AppKit\UI\Styles\Tailwind\Mixins;

use AppKit\UI\AttributeBuilder;

class FocusOutlineMixin extends BaseMixin
{
    public function __invoke(AttributeBuilder $attributeBuilder): void
    {
        $attributeBuilder->addClass(['focus-visible:outline', 'focus-visible:outline-2', 'focus-visible:outline-offset-2']);
    }
}
