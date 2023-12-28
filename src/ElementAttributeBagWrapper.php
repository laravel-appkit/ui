<?php

namespace AppKit\UI;

class ElementAttributeBagWrapper
{
    public function __construct(protected string $element)
    {

    }

    public function run(AttributeBuilder $attributeBuilder)
    {
        return $attributeBuilder->getAttributeBag($this->element);
    }
}
