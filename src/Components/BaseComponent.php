<?php

namespace AppKit\UI\Components;

use Illuminate\View\Component as BladeComponent;

abstract class BaseComponent extends BladeComponent
{
    protected $viewName;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Render the component
     *
     * @return Closure
     */
    public function render()
    {
        return function ($data) {
            $data = $this->runAttributeBuilder($data);

            return view($this->viewName, ...$data);
        };
    }
}
