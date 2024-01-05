<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\AttributeBuilder;
use AppKit\UI\Components\Button as ButtonComponent;
use AppKit\UI\Styles\Tailwind\Mixins\BackgroundColorMixin;
use AppKit\UI\Styles\Tailwind\Mixins\FocusOutlineMixin;
use AppKit\UI\Styles\Tailwind\Tailwind;

class ButtonStyler extends BaseStyler
{
    function __invoke(AttributeBuilder $attributes): void
    {
        $attributes
            ->addClass(['font-semibold', 'shadow-sm'])
            ->mixin(
                FocusOutlineMixin::class,
                BackgroundColorMixin::with(['includeText' => true, 'includeHover' => true])
            )
            ->addClassForSize([
                'xs' => 'px-2 py-1 text-xs',
                'sm' => 'px-2 py-1 text-sm',
                'md' => 'px-2.5 py-1.5 text-sm',
                'lg' => 'px-3 py-2 text-sm',
                'xl' => 'px-3.5 py-2.5 text-sm',
            ])
            ->addClassForShape([
                'square' => '',
                'rounded' => 'rounded-md',
                'pill' => 'rounded-full',
            ]);
    }
}
