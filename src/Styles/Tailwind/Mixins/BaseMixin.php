<?php

namespace AppKit\UI\Styles\Tailwind\Mixins;

use AppKit\UI\AttributeBuilder;
use AppKit\UI\Styles\Tailwind\Tailwind;

abstract class BaseMixin
{
    /**
     * The tailwind styler
     * @var Tailwind
     */
    protected Tailwind $tailwind;

    /**
     * Return a new instance of the mixin with options
     *
     * @return self
     */
    public static function with(?array $options = [])
    {
        return new static($options);
    }

    /**
     * Construct an instance of the mixin, getting all of the dependencies
     *
     * @return void
     */
    public function __construct(protected ?array $options = [])
    {
        $this->tailwind = new Tailwind();
    }

    /**
     * Invoke the mixin
     *
     * @param AttributeBuilder $attributeBuilder
     * @return void
     */
    abstract public function __invoke(AttributeBuilder $attributeBuilder): void;
}
