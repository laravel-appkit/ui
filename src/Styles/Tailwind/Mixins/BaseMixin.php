<?php

namespace AppKit\UI\Styles\Tailwind\Mixins;

use AppKit\UI\ComponentBuilder;
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
    public static function with(...$options)
    {
        return new static(...$options);
    }

    /**
     * Construct an instance of the mixin, getting all of the dependencies
     *
     * @return void
     */
    public function __construct(...$options)
    {
        $this->tailwind = new Tailwind();

        foreach ($options as $option => $value) {
            if (property_exists($this, $option)) {
                $this->{$option} = $value;
            }
        }
    }

    /**
     * Invoke the mixin
     *
     * @param ComponentBuilder $componentBuilder
     * @return void
     */
    abstract public function __invoke(ComponentBuilder $componentBuilder): void;
}
