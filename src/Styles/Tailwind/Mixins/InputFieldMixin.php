<?php

namespace AppKit\UI\Styles\Tailwind\Mixins;

use AppKit\UI\ComponentBuilder;

class InputFieldMixin extends BaseMixin
{
    public function __invoke(ComponentBuilder $componentBuilder): void
    {
        $componentBuilder->addClass([
            'block',
            'border-0',
            'focus:ring-2',
            'focus:ring-sky-600',
            'focus:ring-inset',
            'placeholder:text-gray-400',
            'py-1.5',
            'ring-1',
            'ring-inset',
            'rounded-md',
            'shadow-sm',
            'sm:leading-6',
            'sm:text-sm',

            // disabled
            'disabled:cursor-not-allowed',

            // light mode
            'ring-gray-300',
            'text-gray-900',
            'disabled:bg-gray-50',
            'disabled:text-gray-500',
            'disabled:ring-gray-200',

            // dark mode
            'dark:bg-white/5',
            'dark:text-white',
            'dark:ring-white/10',
            'dark:disabled:bg-gray-900',
            'dark:disabled:text-gray-700',
            'dark:disabled:ring-gray-700',
        ]);

        $componentBuilder->when('hasError', function (ComponentBuilder $componentBuilder) {
            $componentBuilder->addClass([
                'text-red-900',
                'ring-red-300',
                'placeholder:text-red-300',
                'focus:ring-red-500',

                'dark:text-red-600',
                'dark:ring-red-800',
                'dark:placeholder:text-red-800',
                'dark:focus:ring-red-600',
            ]);
        });
    }
}
