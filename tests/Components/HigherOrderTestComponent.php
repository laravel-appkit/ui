<?php

namespace AppKit\UI\Tests\Components;

use AppKit\UI\Tests\Components\TestComponent;
use Closure;
use ReflectionClass;

class HigherOrderTestComponent extends TestComponent
{
    /**
     * The last instantiated instance
     * @var $this
     */
    private static $lastInstance = null;

    /**
     * Render the component
     *
     * @return Closure
     */
    public function render()
    {
        // store the last instance
        static::$lastInstance = $this;

        // call the actual renderer
        return parent::render();
    }

    /**
     * Get the last instance
     *
     * @return static
     */
    public static function lastInstance(): static
    {
        return static::$lastInstance;
    }
}
