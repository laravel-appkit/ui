<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\BaseComponent;

class AppStyler extends BaseStyler
{
    public function __invoke(ComponentBuilder $component, BaseComponent $instance): void
    {
        $component->addClass('[&_[x-cloak]]:hidden');
    }
}
