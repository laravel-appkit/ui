<?php

namespace AppKit\UI;

use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\View\ComponentAttributeBag;

class ElementAttributeBagWrapper {
    function __construct(protected string $element)
    {

    }

    function run(AttributeBuilder $attributeBuilder)
    {
        return $attributeBuilder->getAttributeBag($this->element);
    }
}
