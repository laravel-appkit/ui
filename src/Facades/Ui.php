<?php

namespace AppKit\Ui\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AppKit\Ui\Ui
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
