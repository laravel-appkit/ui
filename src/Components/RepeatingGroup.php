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

    /**
     * Create an instance of the component
     *
     * @param boolean $addAnother
     * @param string $indexName
     * @param boolean $orderable
     * @param string $source
     */
    public function __construct(
        public string $source,
        public bool $addAnother = false,
        public string $indexName = 'index',
        public bool $orderable = false,
    ) {
        // constructor promotion handles the rest
    }
}
