<?php

namespace AppKit\UI\Styles\Tailwind\Mixins;

use AppKit\UI\ComponentBuilder;

class AccentCssVariableMixin extends BaseMixin
{
    public function __invoke(ComponentBuilder $component): void
    {
        $component->addClassForAccent([
            'amber' => '[--ui-accent:var(--color-amber-500)] dark:[--ui-accent:var(--color-amber-500)]',
            'blue' => '[--ui-accent:var(--color-blue-500)] dark:[--ui-accent:var(--color-blue-600)]',
            'cyan' => '[--ui-accent:var(--color-cyan-500)] dark:[--ui-accent:var(--color-cyan-600)]',
            'emerald' => '[--ui-accent:var(--color-emerald-500)] dark:[--ui-accent:var(--color-emerald-600)]',
            'fuchsia' => '[--ui-accent:var(--color-fuchsia-500)] dark:[--ui-accent:var(--color-fuchsia-600)]',
            'green' => '[--ui-accent:var(--color-green-500)] dark:[--ui-accent:var(--color-green-600)]',
            'indigo' => '[--ui-accent:var(--color-indigo-500)] dark:[--ui-accent:var(--color-indigo-600)]',
            'lime' => '[--ui-accent:var(--color-lime-500)] dark:[--ui-accent:var(--color-lime-600)]',
            'orange' => '[--ui-accent:var(--color-orange-500)] dark:[--ui-accent:var(--color-orange-600)]',
            'pink' => '[--ui-accent:var(--color-pink-500)] dark:[--ui-accent:var(--color-pink-600)]',
            'purple' => '[--ui-accent:var(--color-purple-500)] dark:[--ui-accent:var(--color-purple-600)]',
            'red' => '[--ui-accent:var(--color-red-500)] dark:[--ui-accent:var(--color-red-600)]',
            'rose' => '[--ui-accent:var(--color-rose-500)] dark:[--ui-accent:var(--color-rose-600)]',
            'sky' => '[--ui-accent:var(--color-sky-500)] dark:[--ui-accent:var(--color-sky-600)]',
            'teal' => '[--ui-accent:var(--color-teal-500)] dark:[--ui-accent:var(--color-teal-600)]',
            'violet' => '[--ui-accent:var(--color-violet-500)] dark:[--ui-accent:var(--color-violet-600)]',
            'yellow' => '[--ui-accent:var(--color-yellow-500)] dark:[--ui-accent:var(--color-yellow-400)]',
        ]);

        $component->addClassForAccent([
            'amber' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-zinc-950)]',
            'blue' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'cyan' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'emerald' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'fuchsia' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'green' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'indigo' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'lime' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'orange' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'pink' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'purple' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'red' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'rose' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'sky' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'teal' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'violet' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-white)]',
            'yellow' => '[--ui-text-on-accent:var(--color-white)] dark:[--ui-text-on-accent:var(--color-zinc-950)]',
        ]);

        $component->addClassForAccent([
            'amber' => '[--ui-accent-hover:var(--color-amber-600)] dark:[--ui-accent-hover:var(--color-amber-400)]',
            'blue' => '[--ui-accent-hover:var(--color-blue-600)] dark:[--ui-accent-hover:var(--color-blue-500)]',
            'cyan' => '[--ui-accent-hover:var(--color-cyan-600)] dark:[--ui-accent-hover:var(--color-cyan-500)]',
            'emerald' => '[--ui-accent-hover:var(--color-emerald-600)] dark:[--ui-accent-hover:var(--color-emerald-500)]',
            'fuchsia' => '[--ui-accent-hover:var(--color-fuchsia-600)] dark:[--ui-accent-hover:var(--color-fuchsia-500)]',
            'green' => '[--ui-accent-hover:var(--color-green-600)] dark:[--ui-accent-hover:var(--color-green-500)]',
            'indigo' => '[--ui-accent-hover:var(--color-indigo-600)] dark:[--ui-accent-hover:var(--color-indigo-500)]',
            'lime' => '[--ui-accent-hover:var(--color-lime-600)] dark:[--ui-accent-hover:var(--color-lime-500)]',
            'orange' => '[--ui-accent-hover:var(--color-orange-600)] dark:[--ui-accent-hover:var(--color-orange-500)]',
            'pink' => '[--ui-accent-hover:var(--color-pink-600)] dark:[--ui-accent-hover:var(--color-pink-500)]',
            'purple' => '[--ui-accent-hover:var(--color-purple-600)] dark:[--ui-accent-hover:var(--color-purple-500)]',
            'red' => '[--ui-accent-hover:var(--color-red-600)] dark:[--ui-accent-hover:var(--color-red-500)]',
            'rose' => '[--ui-accent-hover:var(--color-rose-600)] dark:[--ui-accent-hover:var(--color-rose-500)]',
            'sky' => '[--ui-accent-hover:var(--color-sky-600)] dark:[--ui-accent-hover:var(--color-sky-500)]',
            'teal' => '[--ui-accent-hover:var(--color-teal-600)] dark:[--ui-accent-hover:var(--color-teal-500)]',
            'violet' => '[--ui-accent-hover:var(--color-violet-600)] dark:[--ui-accent-hover:var(--color-violet-500)]',
            'yellow' => '[--ui-accent-hover:var(--color-yellow-600)] dark:[--ui-accent-hover:var(--color-yellow-300)]',
        ]);
    }
}
