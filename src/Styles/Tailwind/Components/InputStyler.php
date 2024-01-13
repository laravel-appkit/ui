<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Styles\Tailwind\Mixins\ComponentWidth;
use AppKit\UI\Styles\Tailwind\Mixins\InputFieldMixin;

class InputStyler extends BaseStyler
{
    public function __invoke(ComponentBuilder $componentBuilder): void
    {
        // if we aren't a checkbox, we add the normal styling
        $componentBuilder->whenNot('isCheckable', function (ComponentBuilder $componentBuilder) {
            // add the default field styling
            $componentBuilder->mixin(InputFieldMixin::class);

            // handle the component width
            $componentBuilder->mixin(ComponentWidth::class);
        });

        // if we are a checkbox, we need to handle things a little differently
        $componentBuilder->when('isCheckable', function (ComponentBuilder $componentBuilder) {
            $componentBuilder->addClass([
                'h-4',
                'w-4',
                'border-white/10',
                'bg-white/5',
                'text-sky-600',
                'focus:ring-sky-600',
                'focus:ring-offset-gray-900',
            ]);

            $componentBuilder->when('isCheckbox', function (ComponentBuilder $componentBuilder) {
                $componentBuilder->addClass('rounded');
            });
        });

        // handle situations where there is a pre-/post-fix for the field
        $componentBuilder->when('hasAffix', function (ComponentBuilder $componentBuilder) {
            // override background and ring styling on the input
            $componentBuilder->addClass([
                'bg-transparent',
                'flex-1',
                'focus:ring-0',
            ]);

            // remove some further classes from the input
            $componentBuilder->removeClass([
                'ring-1',
                'dark:bg-white/5',
                'focus:ring-2',
                'focus:ring-sky-600',
                'focus:ring-inset',
            ]);

            // make the wrapper look like an input field
            $componentBuilder->addClassToWrapper([
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
            $componentBuilder->addClassWhenHasPrefix('pl-1');
            $componentBuilder->addClassWhenHasPostfix('pr-1');
        });
    }
}
