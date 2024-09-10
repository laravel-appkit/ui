<?php

namespace AppKit\UI;

use Illuminate\Contracts\Support\Htmlable;

class ElementAttributeBag implements Htmlable
{
    private ComponentBuilder $componentBuilder;

    public function __construct(protected string $element)
    {

    }

    public function setComponentBuilder(ComponentBuilder $componentBuilder): self
    {
        $this->componentBuilder = $componentBuilder;

        return $this;
    }

    public function __toString(): string
    {
        return $this->componentBuilder->getAttributeBag($this->element)->__toString();
    }

    public function toHtml(): string
    {
        return $this->__toString();
    }
}
