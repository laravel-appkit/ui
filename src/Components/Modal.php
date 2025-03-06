<?php

namespace AppKit\UI\Components;

use AppKit\UI\Components\Concerns\IsModal;
use AppKit\UI\Facades\UI;

class Modal extends BaseComponent
{
    use IsModal;

    /**
     * Create an instance of the component
     *
     * @param string $name
     * @param string $title
     */
    public function __construct(
        public string $name,
        public string $title,
    ) {
        UI::registerModal($this->name);

        // constructor promotion handles the rest
    }
}
