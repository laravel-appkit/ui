<?php

namespace AppKit\UI\Styles\Tailwind\Mixins;

use AppKit\UI\AttributeBuilder;

class InputFieldMixin extends BaseMixin
{
    public function __invoke(AttributeBuilder $attributeBuilder): void
    {
        $attributeBuilder->addClass([
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
    }
}
