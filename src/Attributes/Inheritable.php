<?php

namespace AppKit\UI\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Inheritable {
    public function __construct(public array|string $fromComponents)
    {

    }
}
