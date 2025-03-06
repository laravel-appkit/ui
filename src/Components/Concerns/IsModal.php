<?php

namespace AppKit\UI\Components\Concerns;

use AppKit\UI\Facades\UI;

trait IsModal {
    /**
     * Returns the alpine expression to determine if the modal is open
     *
     * @return string
     */
    public function isOpen(): string
    {
        return UI::isModalOpen($this->name);
    }

    /**
     * Returns the alpine expression to close a modal
     *
     * @return string
     */
    public function close(): string
    {
        return UI::closeModal($this->name);
    }

    /**
     * Returns the alpine expression open a modal
     *
     * @return string
     */
    public function open(): string
    {
        return UI::openModal($this->name);
    }
}
