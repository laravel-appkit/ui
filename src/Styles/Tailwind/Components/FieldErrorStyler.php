<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\BaseComponent;

class FieldErrorStyler extends BaseStyler
{
    public function __invoke(ComponentBuilder $componentBuilder, BaseComponent $instance): void
    {
        $componentBuilder->addClass(['text-red-600', 'dark:text-red-400']);
    }
}
