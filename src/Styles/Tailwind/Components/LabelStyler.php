<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\BaseComponent;

class LabelStyler extends BaseStyler
{
    public function __invoke(ComponentBuilder $componentBuilder, BaseComponent $instance): void
    {
        $componentBuilder->addClass([
            'font-medium',
            'text-gray-900',
            'leading-6',
            'dark:text-white',
        ]);
    }
}
