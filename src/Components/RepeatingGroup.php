<?php

namespace AppKit\UI\Components;

class RepeatingGroup extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.repeating-group.index';

    public function __construct(
        public string $source,
        public string $indexName = 'index',
        public bool $orderable = false,
        public bool $addAnother = false,
    ) {

    }
}
