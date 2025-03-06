<?php

namespace AppKit\UI\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Element
{
    public function __construct(public string $elementName)
    {

    }
}
