<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\AttributeBuilder;

class InputStyler extends BaseStyler
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

        // handle situations where there is a pre-/post-fix for the field
        $attributeBuilder->when('hasAffix', function (AttributeBuilder $attributeBuilder) {
            // override background and ring styling on the input
            $attributeBuilder->addClass([
                'bg-transparent',
                'flex-1',
                'focus:ring-0',
            ]);

            // remove some further classes from the input
            $attributeBuilder->removeClass([
                'ring-1',
                'dark:bg-white/5',
                'focus:ring-2',
                'focus:ring-sky-600',
                'focus:ring-inset',
            ]);

            // make the wrapper look like an input field
            $attributeBuilder->addClassToWrapper([
                'flex',
                'rounded-md',
                'shadow-sm',
                'ring-1',
                'ring-inset',
                'ring-gray-300',
                'focus-within:ring-2',
                'focus-within:ring-inset',
                'focus-within:ring-sky-600',
                'sm:max-w-md',

                // dark mode
                'dark:bg-white/5',
                'dark:text-white',
                'dark:ring-white/10',
            ]);

            // change the padding of the field depending on pre-/post-fixes
            $attributeBuilder->addClassWhenHasPrefix('pl-1');
            $attributeBuilder->addClassWhenHasPostfix('pr-1');
        });

        // handle the input field widths
        $attributeBuilder->addClassForWidth([
            'sm' => 'w-1/4',
            'md' => 'w-1/2',
            'lg' => 'w-3/4',
            'full' => 'w-full',
        ]);
    }
}
