<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\AttributeBuilder;
use AppKit\UI\Styles\Tailwind\Mixins\ComponentWidth;
use AppKit\UI\Styles\Tailwind\Mixins\InputFieldMixin;

class InputStyler extends BaseStyler
{
    public function __invoke(AttributeBuilder $attributeBuilder): void
    {
        // add the default field styling
        $attributeBuilder->mixin(InputFieldMixin::class);

        // handle the component width
        $attributeBuilder->mixin(ComponentWidth::class);

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
    }
}
