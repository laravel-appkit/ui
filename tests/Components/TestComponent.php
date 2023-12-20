<?php

namespace AppKit\UI\Tests\Components;

use Illuminate\View\Component;

class TestComponent extends Component
{
    public $property = true;

    public function __construct()
    {
        dump('HELLO!!!');
    }

    public function render()
    {

    }
}
