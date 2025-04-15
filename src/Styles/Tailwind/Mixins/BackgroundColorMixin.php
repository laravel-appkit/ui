<?php

namespace AppKit\UI\Styles\Tailwind\Mixins;

use AppKit\UI\ComponentBuilder;
use InvalidArgumentException;

class BackgroundColorMixin extends BaseMixin
{
    /**
     * Include classes relating to hover states
     *
     * @var boolean
     */
    protected $includeHover = false;

    /**
     * Include classes relating to text colour
     *
     * @var boolean
     */
    protected $includeText = false;

    /**
     * Invoke the mixin
     *
     * @param ComponentBuilder $component
     * @return void
     * @throws InvalidArgumentException
     */
    public function __invoke(ComponentBuilder $component): void
    {
        $component->addClassForColor([
            'accent' => 'bg-[var(--ui-accent)]',
            'amber' => 'bg-amber-500 dark:bg-amber-500',
            'blue' => 'bg-blue-500 dark:bg-blue-600',
            'cyan' => 'bg-cyan-500 dark:bg-cyan-600',
            'emerald' => 'bg-emerald-500 dark:bg-emerald-600',
            'fuchsia' => 'bg-fuchsia-500 dark:bg-fuchsia-600',
            'green' => 'bg-green-500 dark:bg-green-600',
            'indigo' => 'bg-indigo-500 dark:bg-indigo-600',
            'lime' => 'bg-lime-500 dark:bg-lime-600',
            'orange' => 'bg-orange-500 dark:bg-orange-600',
            'pink' => 'bg-pink-500 dark:bg-pink-600',
            'purple' => 'bg-purple-500 dark:bg-purple-600',
            'red' => 'bg-red-500 dark:bg-red-600',
            'rose' => 'bg-rose-500 dark:bg-rose-600',
            'sky' => 'bg-sky-500 dark:bg-sky-600',
            'teal' => 'bg-teal-500 dark:bg-teal-600',
            'violet' => 'bg-violet-500 dark:bg-violet-600',
            'yellow' => 'bg-yellow-500 dark:bg-yellow-400',
        ]);

        if ($this->includeText) {
            $component->addClassForColor([
                'accent' => 'text-[var(--ui-text-on-accent)]',
                'amber' => 'text-white dark:text-zinc-950',
                'blue' => 'text-white dark:text-white',
                'cyan' => 'text-white dark:text-white',
                'emerald' => 'text-white dark:text-white',
                'fuchsia' => 'text-white dark:text-white',
                'green' => 'text-white dark:text-white',
                'indigo' => 'text-white dark:text-white',
                'lime' => 'text-white dark:text-white',
                'orange' => 'text-white dark:text-white',
                'pink' => 'text-white dark:text-white',
                'purple' => 'text-white dark:text-white',
                'red' => 'text-white dark:text-white',
                'rose' => 'text-white dark:text-white',
                'sky' => 'text-white dark:text-white',
                'teal' => 'text-white dark:text-white',
                'violet' => 'text-white dark:text-white',
                'yellow' => 'text-white dark:text-zinc-950',
            ]);
        }

        if ($this->includeHover) {
            $component->addClassForColor([
                'accent' => 'hover:bg-[var(--ui-accent-hover)]',
                'amber' => 'hover:bg-amber-600 dark:hover:bg-amber-400',
                'blue' => 'hover:bg-blue-600 dark:hover:bg-blue-500',
                'cyan' => 'hover:bg-cyan-600 dark:hover:bg-cyan-500',
                'emerald' => 'hover:bg-emerald-600 dark:hover:bg-emerald-500',
                'fuchsia' => 'hover:bg-fuchsia-600 dark:hover:bg-fuchsia-500',
                'green' => 'hover:bg-green-600 dark:hover:bg-green-500',
                'indigo' => 'hover:bg-indigo-600 dark:hover:bg-indigo-500',
                'lime' => 'hover:bg-lime-600 dark:hover:bg-lime-500',
                'orange' => 'hover:bg-orange-600 dark:hover:bg-orange-500',
                'pink' => 'hover:bg-pink-600 dark:hover:bg-pink-500',
                'purple' => 'hover:bg-purple-600 dark:hover:bg-purple-500',
                'red' => 'hover:bg-red-600 dark:hover:bg-red-500',
                'rose' => 'hover:bg-rose-600 dark:hover:bg-rose-500',
                'sky' => 'hover:bg-sky-600 dark:hover:bg-sky-500',
                'teal' => 'hover:bg-teal-600 dark:hover:bg-teal-500',
                'violet' => 'hover:bg-violet-600 dark:hover:bg-violet-500',
                'yellow' => 'hover:bg-yellow-600 dark:hover:bg-yellow-300',
            ]);
        }
    }
}
