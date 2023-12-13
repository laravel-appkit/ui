<?php

namespace AppKit\UI\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AppKit\UI\Ui
 */
class Ui extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ui';
    }
}
