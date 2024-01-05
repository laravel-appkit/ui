<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\AttributeBuilder;

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
     * @param AttributeBuilder $attributeBuilder
     * @return void
     */
    abstract public function __invoke(AttributeBuilder $attributeBuilder): void;
}
