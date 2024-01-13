<?php

namespace AppKit\UI;

use Illuminate\Contracts\Support\Htmlable;

class ElementAttributeBagWrapper implements Htmlable
{
    private $elements;

    public function __construct(protected string $element)
    {

    }

    public function run(ComponentBuilder $componentBuilder)
    {
        $this->elements = $componentBuilder->getAttributeBag($this->element);
    }

    public function __toString()
    {
        return $this->elements->__toString();
    }

    public function toHtml()
    {
        return $this->__toString();
    }
}
