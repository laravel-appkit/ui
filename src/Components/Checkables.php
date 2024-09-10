<?php

namespace AppKit\UI\Components;

class Checkables extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.checkables';

    public string $itemComponentName = '';

    public function __construct(
        public string $id,
        public string $label,
        public string $type,
        public array $options,
    ) {
        $this->itemComponentName = ($this->type == 'radio') ? 'appkit::radio' : 'appkit::checkbox';
    }
}
