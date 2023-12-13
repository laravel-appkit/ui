<?php

namespace AppKit\UI\Components;

use Illuminate\View\Component as BladeComponent;

abstract class BaseComponent extends BladeComponent
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
