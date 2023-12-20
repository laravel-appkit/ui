<?php

namespace AppKit\UI\Tests\Components;

class HigherOrderTestComponent extends TestComponent
{
    /**
     * The last instantiated instance
     * @var $this
     */
    static $lastInstance = null;

    public function __construct()
    {
        static::$lastInstance = $this;

        if (method_exists(parent::class, '__construct')) {
            parent::__construct(...func_get_args());
        }
    }
}
