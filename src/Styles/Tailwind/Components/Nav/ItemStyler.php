<?php

namespace AppKit\UI\Styles\Tailwind\Components\Nav;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\BaseComponent;
use AppKit\UI\Styles\Tailwind\Components\BaseStyler;

class ItemStyler extends BaseStyler
{
    public function __invoke(ComponentBuilder $component, BaseComponent $instance): void
    {
        $component
            ->addClass('flex gap-2 items-center pl-4 py-[5px] first:pt-0 last:pb-0 border-l-2 border-zinc-100 dark:border-zinc-500 text-zinc-500 dark:text-zinc-300 hover:text-zinc-800 dark:hover:text-white')
            ->addClassWhenCurrent('dark:text-teal-300 dark:border-teal-500');
    }
}
