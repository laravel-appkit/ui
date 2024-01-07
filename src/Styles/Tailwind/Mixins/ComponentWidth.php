<?php

namespace AppKit\UI\Styles\Tailwind\Mixins;

use AppKit\UI\AttributeBuilder;

class ComponentWidth extends BaseMixin
{
    public function __invoke(AttributeBuilder $attributeBuilder): void
    {
        $attributeBuilder->addClassForWidth([
            'sm' => 'w-1/4',
            'md' => 'w-1/2',
            'lg' => 'w-3/4',
            'full' => 'w-full',
        ]);
    }
}
