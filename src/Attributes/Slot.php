<?php

namespace AppKit\UI\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class Slot
{
    public function __construct(
        protected string $name,
        protected bool $default = false,
    ) {

    }
}
