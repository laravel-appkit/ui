<?php

namespace AppKit\UI\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Slotable
{
    public function __construct(public ?string $slotName = null)
    {

    }
}
