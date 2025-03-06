<?php

namespace AppKit\UI\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER|Attribute::TARGET_METHOD)]
final class ExposedAsState
{
    public function __construct()
    {

    }
}
