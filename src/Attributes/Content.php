<?php

namespace AppKit\UI\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_METHOD)]
final class Content
{
    public function __construct()
    {

    }
}
