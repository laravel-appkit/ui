<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\BaseComponent;

class HeadingStyler extends BaseStyler
{
    public function __invoke(ComponentBuilder $componentBuilder, BaseComponent $instance): void
    {
        $componentBuilder->addClassForLevel([
            1 => '',
            2 => 'mb-8 lg:mb-3 font-semibold text-lg text-slate-900 dark:text-slate-200',
            3 => 'my-4 lg:my-2 font-semibold text-slate-900 dark:text-slate-200',
            4 => '',
            5 => '',
            6 => '',
        ]);
    }
}
