<?php

namespace AppKit\UI\Styles\Tailwind\Mixins;

use AppKit\UI\ComponentBuilder;

class BackdropMixin extends BaseMixin
{
    public function __invoke(ComponentBuilder $component): void
    {
        $component->addClass([
            'backdrop:transition-all', 'backdrop:transition-discrete', 'backdrop:duration-300',
            'backdrop:bg-transparent',
            'open:backdrop:bg-zinc-500/80',
            'starting:open:backdrop:bg-transparent',
        ]);
    }
}
