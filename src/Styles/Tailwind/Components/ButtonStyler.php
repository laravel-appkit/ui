<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\BaseComponent;
use AppKit\UI\Styles\Tailwind\Mixins\BackgroundColorMixin;
use AppKit\UI\Styles\Tailwind\Mixins\FocusOutlineMixin;

// #[CustomisesComponent(Button::class)]
class ButtonStyler extends BaseStyler /* Implements ComponentCustomiser */
{
    public function __invoke(ComponentBuilder $component, BaseComponent $instance): void
    {
        $component
            ->addClass(['font-semibold', 'shadow-sm', 'transition-colors'])
            ->mixin(
                FocusOutlineMixin::class,
                BackgroundColorMixin::with(includeHover: true, includeText: true)
            )
            ->addClassForSize([
                'xs' => 'px-2 py-1 text-xs',
                'sm' => 'px-2 py-1 text-sm',
                'md' => 'px-2.5 py-1.5 text-sm',
                'lg' => 'px-3 py-2 text-sm',
                'xl' => 'px-3.5 py-2.5 text-md',
            ])
            ->addClassForShape([
                'square' => '',
                'rounded' => 'rounded-md',
                'pill' => 'rounded-full',
            ]);
    }
}
