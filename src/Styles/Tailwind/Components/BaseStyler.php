<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Styles\Tailwind\Tailwind;

abstract class BaseStyler
{
    /**
     * The tailwind styler
     * @var Tailwind
     */
    protected Tailwind $tailwind;

    /**
     * Create an instance of the styler
     *
     * @return void
     */
    public function __construct()
    {
        $this->tailwind = new Tailwind();
    }

    /**
     * Run the styler
     *
     * @param ComponentBuilder $componentBuilder
     * @return void
     */
    abstract public function __invoke(ComponentBuilder $componentBuilder): void;
}
