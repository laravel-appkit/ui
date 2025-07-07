<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\BaseComponent;
use AppKit\UI\Styles\Tailwind\Mixins\BackdropMixin;
use AppKit\UI\Styles\Tailwind\Mixins\Interactivity\ModalMixin;

class DrawerStyler extends BaseStyler
{
    public function __invoke(ComponentBuilder $component, BaseComponent $instance): void
    {
        // style the actual modal
        $component->addClass([
            'min-h-dvh',
            'fixed pointer-events-auto fixed w-screen max-w-2xl m-0 ml-auto',
            'transition-all', 'transition-discrete', 'duration-300',
            'starting:open:translate-x-full',
            'translate-x-full',
            'open:translate-x-0',
        ]);

        // add in the backdrop
        $component->mixin(BackdropMixin::class);

        // add in the interactivity of the modal (click events etc)
        $component->mixin(ModalMixin::with(modal: $instance));
    }
}
