<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\BaseComponent;

class NavStyler extends BaseStyler
{
    public function __invoke(ComponentBuilder $component, BaseComponent $instance): void
    {
        $component->addClass('flex flex-col overflow-visible min-h-auto space-y-6');
    }
}
