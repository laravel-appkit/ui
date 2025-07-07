<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\BaseComponent;
use AppKit\UI\Styles\Tailwind\Mixins\BackdropMixin;
use AppKit\UI\Styles\Tailwind\Mixins\Interactivity\ModalMixin;

class ModalStyler extends BaseStyler
{
    public function __invoke(ComponentBuilder $component, BaseComponent $instance): void
    {
        // style the actual modal
        $component->addClass([
            'm-auto',
            'transition-all', 'transition-discrete', 'duration-300',
            'starting:open:opacity-0', 'starting:open:scale-95', 'starting:open:-translate-y-20',
            'opacity-0', 'scale-80', 'translate-y-40',
            'open:opacity-100', 'open:scale-100', 'open:translate-y-0',
        ]);

        // add in the backdrop
        $component->mixin(BackdropMixin::class);

        // add in the interactivity of the modal (click events etc)
        $component->mixin(ModalMixin::with(modal: $instance));
    }
}
