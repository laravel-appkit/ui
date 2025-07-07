<?php

namespace AppKit\UI\Styles\Tailwind\Mixins\Interactivity;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\BaseComponent;
use AppKit\UI\Styles\Tailwind\Mixins\BaseMixin;

class ModalMixin extends BaseMixin
{
    /**
     * The modal style component that we are applying this to
     *
     * @var BaseComponent
     */
    public BaseComponent $modal;

    public function __invoke(ComponentBuilder $component): void
    {
        // add a watcher, to open/close the modal depending on the state of the AlpineJS variable
        $component->addAttribute('x-init', "\$watch('" . $this->modal->runtimeVariable() . "', (v) => (v) ? \$el.showModal() : \$el.close())");

        // make sure that if we close the modal, we update the variable, this keep everything in sync
        $component->addAttribute('@close', $this->modal->close());

        // check if we click (outside of the modal), if so, we update the variable
        $component->addAttribute('@click', $this->modal->runtimeVariable() . ' = ($event.target !== $el)');
    }
}
