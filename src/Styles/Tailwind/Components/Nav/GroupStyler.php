<?php

namespace AppKit\UI\Styles\Tailwind\Components\Nav;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\BaseComponent;
use AppKit\UI\Styles\Tailwind\Components\BaseStyler;

class GroupStyler extends BaseStyler
{
    public function __invoke(ComponentBuilder $component, BaseComponent $instance): void
    {
        $component->addClassToTitle('mb-8 lg:mb-3 font-semibold text-slate-900 dark:text-slate-200 space-y-3');
    }
}
