<?php

namespace AppKit\UI\Styles\Tailwind\Mixins;

use AppKit\UI\ComponentBuilder;

class ComponentWidth extends BaseMixin
{
    public function __invoke(ComponentBuilder $componentBuilder): void
    {
        $componentBuilder->addClassForWidth([
            'sm' => 'w-1/4',
            'md' => 'w-1/2',
            'lg' => 'w-3/4',
            'full' => 'w-full',
        ]);
    }
}
