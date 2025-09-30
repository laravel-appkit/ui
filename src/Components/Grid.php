<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\State;

class Grid extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.grid.index';

    /**
     * Create an instance of the component
     *
     * @param int $columns
     * @param int $gap
     */
    public function __construct(
        #[State]
        public int $columns = 12,
        #[State]
        public int $gap = 3,
    ) {
        // constructor promotion handles the rest
    }
}
