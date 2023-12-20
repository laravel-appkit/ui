<?php

namespace AppKit\UI\Tests\Components;

class HigherOrderTestComponent extends TestComponent
{
    /**
     * The last instantiated instance
     * @var $this
     */
    public static $lastInstance = null;

    public function __construct()
    {
        // store the last instance
        static::$lastInstance = $this;

        // check if we are extending a class that has a constructor
        if (method_exists(parent::class, '__construct')) {
            // call the parent constructor with all of the arguments passed
            parent::__construct(...func_get_args());
        }
    }
}
