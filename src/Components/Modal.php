<?php

namespace AppKit\UI\Components;

use AppKit\UI\Facades\UI;

class Modal extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.modal';

    public function __construct(
        public string $name,
        public string $title,
    ) {
        UI::registerModal($this->name);
    }

    public function isOpen()
    {
        return UI::isModalOpen($this->name);
    }

    public function close()
    {
        return UI::closeModal($this->name);
    }

    public function open()
    {
        return UI::openModal($this->name);
    }
}
