<?php

namespace AppKit\UI\Styles\Tailwind\Mixins;

use AppKit\UI\ComponentBuilder;

class FocusOutlineMixin extends BaseMixin
{
    public function __invoke(ComponentBuilder $componentBuilder): void
    {
        $componentBuilder->addClass([
            'focus-visible:outline',
            'focus-visible:outline-2',
            'focus-visible:outline-offset-2',
        ]);
    }
}
