<?php

namespace AppKit\UI\Components;

class RepeatingGroup extends BaseComponent
{
    protected $viewName = 'appkit-ui::components.repeating-group.index';

    public function __construct(
        public string $source,
        public string $indexName = 'index',
        public bool $orderable = false,
        public bool $addAnother = false,
    ) {

    }
}
