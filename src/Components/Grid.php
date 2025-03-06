<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\ExposedAsState;

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
     * @param integer $columns
     * @param integer $gap
     */
    public function __construct(
        #[ExposedAsState]
        public int $columns = 12,

        #[ExposedAsState]
        public int $gap = 3,
    ) {
        // constructor promotion handles the rest
    }
}
