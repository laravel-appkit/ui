<?php

namespace AppKit\UI\Components\Grid;

use AppKit\UI\Components\BaseComponent;

class Column extends BaseComponent
{
    /**
     * Create an instance of the component
     *
     * @param integer $width
     */
    public function __construct(
        public int $width,
    ) {
        // constructor promotion handles the rest
    }
}
