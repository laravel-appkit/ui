<?php

namespace AppKit\UI\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class AppkitComponent
{
    public function __construct(
        protected string $name,
    ) {

    }
}
